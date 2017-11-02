<?php namespace Engen\Repos;

use Engen\Entities\Page;
use Maer\FileDB\FileDB;

class PagesFileDB implements PagesInterface
{
    /**
     * @var FileDB
     */
    protected $db;

    /**
     * @var string
     */
    protected $contentPath;

    /**
     * List of matching pages uri => id
     * @var array
     */
    protected $uris  = [];

    /**
     * @var array
     */
    protected $pages = [];

    /**
     * List of matching pages key => id
     * @var array
     */
    protected $pageKeys = [];

    /**
     * List of page parent_id => [id, id, ...]
     * @var array
     */
    protected $pageParents = [];


    /**
     * @param FileDB $db
     * @param string $contentPath
     */
    public function __construct(FileDB $db, $contentPath)
    {
        $this->db = $db;
        $this->contentPath = $contentPath;

        $this->loadPages();
    }


    /**
     * Get list of all pages
     *
     * @return array
     */
    public function getPages()
    {
        return array_values($this->pages);
    }


    /**
     * Get a page by uri
     *
     * @param  string $uri
     * @return Page|null
     */
    public function getPageByUri($uri)
    {
        return $this->getPageById($this->uris[$uri] ?? null);
    }


    /**
     * Get all pages with slug
     *
     * @param  string $slug
     * @return array
     */
    public function getPagesWithSlug($slug)
    {
        $result = $this->db->pages
            ->where('slug', $slug)
            ->get();

        return $result ? Page::make($result) : [];
    }


    /**
     * Get the page with slug and parent
     *
     * @param  string $slug
     * @param  string $parentId
     * @return array
     */
    public function getPageWithSlugAndParent($slug, $parentId)
    {
        return $this->db->pages
            ->where('slug', $slug)
            ->where('parent_id', $parentId)
            ->asObj('Engen\Entities\Page')
            ->first();
    }


    /**
     * Get a page by id
     *
     * @param  integer $id
     * @return Page|null
     */
    public function getPageById($id)
    {
        if (!$page = ($this->pages[$id] ?? null)) {
            return null;
        }

        $page->content = $this->getPageContent($id);
        return $page;
    }


    /**
     * Get a page by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageByKey($key)
    {
        return $this->getPageById($this->pageKeys[$key] ?? null);
    }


    /**
     * Get a page uri by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageUriByKey($key)
    {
        $id = $this->pageKeys[$key] ?? null;
        if (!$id || !isset($this->pages[$id])) {
            return null;
        }

        return $this->pages[$id]->uri;
    }


    /**
     * Get page children
     *
     * @param  string $id
     * @return array
     */
    public function getPageChildren($id)
    {
        $cids = $this->pageParents[$id] ?? null;
        if (empty($cids)) {
            return [];
        }

        $list = [];
        foreach ($cids as $cid) {
            if (!isset($this->pages[$cid])) {
                continue;
            }

            $list[] = $this->pages[$cid];
        }

        return $list;
    }


    /**
     * Get page content
     *
     * @param  string $id
     * @return array
     */
    public function getPageContent($id)
    {
        $file = $this->contentPath . "/{$id}.json";
        if (is_file($file)) {
            $content = json_decode(file_get_contents($file), true);
        }

        return empty($content) || !is_array($content)
            ? []
            : $content;
    }


    /**
     * Update a page
     *
     * @param  string $id
     * @param  array  $info
     * @param  array  $content
     * @return Page|null
     */
    public function updatePage($id, array $info, array $content)
    {
        if (!$page = $this->pages[$id] ?? null) {
            return false;
        }

        $file = $this->contentPath . "/{$id}.json";
        if (!file_put_contents($file, json_encode($content))) {
            return false;
        }

        if (empty($info['updated'])) {
            $info['updated'] = time();
        }

        if ($page->created == 0) {
            $page->created = time();
        }

        if (!empty($info['is_home']) && $info['is_home'] == 1) {
            // This is set to be the home page, remove the current
            $this->db->pages->where('is_home', 1)->update(['is_home' => 0]);
        }

        $data = array_replace($page->toArray(['id', 'content']), $info);

        if ($this->db->pages->where('id', $id)->update($data) < 1) {
            return false;
        }

        $this->regenerateUris();
        return $this->pages[$id] ?? false;
    }


    /**
     * Add a new page
     *
     * @param  Page   $page
     * @param  array  $content
     * @return Page|null
     */
    public function createPage(Page $page, array $content)
    {
        $page->created = (int) $page->created > 0 ? $page->created : time();
        $page->updated = (int) $page->updated > 0 ? $page->updated : time();

        if ($page->is_home == 1) {
            // This is set to be the home page, remove the current
            $this->db->pages->where('is_home', 1)->update(['is_home' => 0]);
        }

        if (!$id = $this->db->pages->insert($page->toArray(['id', 'content']))) {
            return false;
        }

        $file = $this->contentPath . "/{$id}.json";
        if (file_put_contents($file, json_encode($content)) < 1) {
            return false;
        }

        $this->regenerateUris();
        return $this->pages[$id] ?? false;
    }


    /**
     * Load page list
     */
    protected function loadPages()
    {
        $this->pages       = [];
        $this->pageKeys    = [];
        $this->uris        = [];
        $this->pageParents = [];

        $pages = $this->db->pages->orderBy('uri', 'asc')->get();

        foreach ($pages as $item) {
            $this->pages[$item['id']] = Page::make($item);
            $this->uris[$item['uri']] = $item['id'];
            $this->pageKeys[$item['key']] = $item['id'];

            $pid = $item['parent_id'] ?: 'root';
            if (!isset($this->pageParents[$pid])) {
                $this->pageParents[$pid] = [];
            }

            $this->pageParents[$pid][$item['id']] = $item['id'];
        }
    }


    /**
     * Generate full uri's
     *
     * @return array
     */
    public function regenerateUris()
    {
        // Load all stored info
        $this->loadPages();

        foreach ($this->pages as &$page) {
            if ($page->is_home) {
                $uri   = '/';
                $level = 0;
            } else {
                $parentSlug = !empty($page->parent_id)
                    ? $this->getParentSlug($page->parent_id)
                    : '';

                $uri   = '/' . trim($parentSlug . '/' . $page->slug, '/');
                $level = substr_count($uri, '/', 1);
            }

            // Update the uri and level in the meta table
            $page->uri   = $uri;
            $page->level = $level;
            $this->db->pages
                ->where('id', $page->id)
                ->update(['uri' => $page->uri, 'level' => $page->level]);
        }

        // Load all update info
        $this->loadPages();
    }


    /**
     * Get the parent uri
     *
     * @param  string $parentId
     * @return string
     */
    protected function getParentSlug($parentId)
    {
        $slug   = $this->pages[$parentId]->slug ?? null;

        $parent = !empty($this->pages[$parentId]->parent_id)
            ? $this->getParentSlug($this->pages[$parentId]->parent_id)
            : '';

        return is_null($slug) ? '' : $parent . '/' . $slug;
    }
}
