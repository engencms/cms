<?php namespace Engen\Repos;

use Engen\Entities\Page;

interface PagesInterface
{
    /**
     * Get list of all pages
     *
     * @return array
     */
    public function getPages();


    /**
     * Get a page by uri
     *
     * @param  string $uri
     * @return Page|null
     */
    public function getPageByUri($uri);


    /**
     * Get all pages with slug
     *
     * @param  string $slug
     * @return array
     */
    public function getPagesWithSlug($slug);


    /**
     * Get the page with slug and parent
     *
     * @param  string $slug
     * @param  string $parentId
     * @return array
     */
    public function getPageWithSlugAndParent($slug, $parentId);


    /**
     * Get a page by id
     *
     * @param  integer $id
     * @return Page|null
     */
    public function getPageById($id);


    /**
     * Get a page by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageByKey($key);


    /**
     * Get a page uri by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getPageUriByKey($key);


    /**
     * Get page children
     *
     * @param  string $id
     * @return array
     */
    public function getPageChildren($id);


    /**
     * Get page content
     *
     * @param  string $id
     * @return array
     */
    public function getPageContent($id);


    /**
     * Update a page
     *
     * @param  string $id
     * @param  array  $info
     * @param  array  $content
     * @return Page|null
     */
    public function updatePage($id, array $info, array $content);


    /**
     * Add a new page
     *
     * @param  Page   $page
     * @param  array  $content
     * @return Page|null
     */
    public function createPage(Page $page, array $content);
}
