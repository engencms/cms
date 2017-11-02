<?php namespace Engen\Repos;

use Engen\Entities\Menu;

interface MenusInterface
{
    /**
     * Get all menus
     *
     * @return array
     */
    public function getMenus();


    /**
     * Get a menu by key
     *
     * @param  string $key
     * @return Menu|null
     */
    public function getMenuByKey($key);


    /**
     * Get a menu by id
     *
     * @param  integer $id
     * @return Menu|null
     */
    public function getMenuById($id);


    /**
     * Update a menu
     *
     * @param  string $id
     * @param  array  $data
     * @return Menu|null
     */
    public function updateMenu($id, array $data);


    /**
     * Add a new menu
     *
     * @param  Menu   $menu
     * @return Menu|null
     */
    public function createMenu(Menu $menu);


    /**
     * Delete a menu
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteMenu($id);
}
