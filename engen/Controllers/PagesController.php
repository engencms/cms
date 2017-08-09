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
            'status'    => $data['status'] ?? null,
        ];

        $result = $this->validator->page($info, $id);
        if ($result !== true) {
            return $response->setErrors($result)
                ->setMessage('validation_error');
        }

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
}
