<?php namespace Engen\Controllers;

use Engen\Entities\Page;

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Pages' => $this->router->getRoute('engen.pages'),
        ]);
    }


    /**
     * Show page list
     *
     * @return string
     */
    public function showPages()
    {
        return $this->views->render("admin::pages/list");
    }


    /**
     * Show edit page form
     *
     * @param  string $id
     * @return string
     */
    public function editPage($id)
    {
       $this->addBreadCrumb([
            'Edit' => $this->router->getRoute('engen.pages.edit', [$id]),
        ]);

        if (!$page = $this->pages->getPageById($id)) {
            return $this->routeRedirect('engen.pages');
        }

        return $this->views->render("admin::pages/edit", [
            'page'    => $page,
        ]);
    }


    /**
     * Show new page form
     *
     * @return string
     */
    public function newPage()
    {
        $this->addBreadCrumb([
            'New' => $this->router->getRoute('engen.pages.new'),
        ]);

        return $this->views->render("admin::pages/edit", [
            'page' => new Page,
        ]);
    }


    /**
     * Add/Update page
     *
     * @return JsonEntity
     */
    public function savePage()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-page')) {
            return $response->setError('Invalid token. Please update page and try again.');
        }

        $id     = $this->request->post('id');
        $fields = $this->request->post('field', []);
        $data   = $this->request->post('info');
        $info   = [
            'slug'      => $data['slug']      ?? null,
            'key'       => $data['key']       ?? null,
            'template'  => $data['template']  ?? null,
            'title'     => $data['title']     ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'is_home'   => $data['is_home']   ?? 0,
            'status'    => $data['status']    ?? null,
        ];

        $result = $this->validator->page($info, $id);
        if ($result !== true) {
            return $response->setErrors($result)
                ->setMessage('validation_error');
        }

        $fields = $this->reorderFields($fields);

        if ($id) {
            if (!$this->pages->updatePage($id, $info, $fields)) {
                return $response->setError('Error updating page');
            }
        } else {
            if (!$page = $this->pages->createPage(new Page($info), $fields)) {
                return $response->setError('Error creating page');
            }

            $id = $page->id;
        }

        $this->session->setFlash('success', 'Page saved');

        return $response->setData($this->router->getRoute('engen.pages.edit', [$id]));
    }


    /**
     * Create a unique page slug
     *
     * @return JsonEntity
     */
    public function slugifySlug()
    {
        $response = $this->makeJsonEntity();

        $text     = $this->request->get('text');
        $pageId   = $this->request->get('page_id');
        $parentId = $this->request->get('parent_id');
        $text     = $this->slugifier->slugify($text);

        $parentId = empty($parentId) ? null : $parentId;

        $slug   = $text;
        $i      = 2;

        while ($page = $this->app->pages->getPageWithSlugAndParent($slug, $parentId)) {
            if ($page->id == $pageId) {
                break;
            }

            $slug = $text . '-' . $i;
            $i++;
        }

        return $response->setData($slug);
    }


    /**
     * Create a unique page key
     *
     * @return JsonEntity
     */
    public function slugifyKey()
    {
        $response = $this->makeJsonEntity();

        $text     = $this->request->get('text');
        $pageId   = $this->request->get('page_id');
        $text     = $this->slugifier->slugify($text);

        $key      = $text;
        $i        = 2;

        while ($page = $this->pages->getPageByKey($key)) {
            if ($page->id == $pageId) {
                break;
            }

            $key = $text . '-' . $i;
            $i++;
        }

        return $response->setData($key);
    }


    /**
     * Reorder content
     *
     * @param  array $content
     * @return array
     */
    protected function reorderFields(array $content)
    {
        $new = [];

        foreach ($content as $key => $value) {
            if (is_array($value) && count($value) > 0 && !array_key_exists(0, $value)) {
                $new[$key] = $this->fixPostArray($value);
                continue;
            }

            $new[$key] = $value;
        }

        return $new;
    }


    /**
     * Fix post arrays to be key => value
     *
     * @param  array  $data
     * @return array
     */
    protected function fixPostArray(array $data)
    {
        $keys  = array_keys($data);
        $fixed = [];

        foreach ($data[$keys[0]] as $index => $value) {
            $item = [];
            foreach ($keys as $key) {
                $item[$key] = $data[$key][$index] ?? null;
            }

            $fixed[] = $item;
        }

        return $fixed;
    }
}
