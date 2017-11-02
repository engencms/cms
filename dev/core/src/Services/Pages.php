<?php namespace Engen\Services;

use Engen\Entities\Page;
use Engen\Repos\PagesInterface;

class Pages
{
    protected $definitions;
    protected $repo;

    public function __construct(Definitions $definitions, PagesInterface $repo)
    {
        $this->definitions = $definitions;
        $this->repo        = $repo;
    }


    /**
     * Get list of all pages
     *
     * @return array
     */
    public function getPages()
    {
        return $this->repo->getPages();
    }


    /**
     * Get a page by uri
     *
     * @param  string $uri
     * @return Page|null
     */
    public function getPageByUri($uri)
    {
        return $this->repo->getPageByUri($uri);
    }


    /**
     * Get all pages with slug
     *
     * @param  string $slug
     * @return array
     */
    public function getPagesWithSlug($slug)
    {
        return $this->repo->getPagesWithSlug($slug);
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
        return $this->repo->getPageWithSlugAndParent($slug, $parentId);
    }


    /**
     * Get a page by id
     *
     * @param  integer $id
     * @return Page|null
     */
    public function getPageById($id)
    {
        return $this->repo->getPageById($id);
    }


    /**
     * Get a page by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageByKey($key)
    {
        return $this->repo->getPageByKey($key);
    }


    /**
     * Get a page uri by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageUriByKey($key)
    {
        return $this->repo->getPageUriByKey($key);
    }


    /**
     * Get page children
     *
     * @param  string $id
     * @return array
     */
    public function getPageChildren($id)
    {
        return $this->repo->getPageChildren($id);
    }


    /**
     * Get page content
     *
     * @param  string $id
     * @return array
     */
    public function getPageContent($id)
    {
        return $this->repo->getPageContent($id);
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
        return $this->repo->updatePage($id, $info, $content);
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
        return $this->repo->createPage($page, $content);
    }
}
