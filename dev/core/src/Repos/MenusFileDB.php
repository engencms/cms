<?php namespace Engen\Repos;

use Engen\Entities\Menu;
use Engen\Entities\MenuItem;
use Maer\FileDB\FileDB;

class MenusFileDB implements MenusInterface
{
    /**
     * @var FileDB
     */
    protected $db;

    /**
     * List of menus with the ID as key
     * @var array
     */
    protected $menus = [];

    /**
     * List of matching menu key => id
     * @var array
     */
    protected $menuKeys = [];


    /**
     * @param FileDB $db
     */
    public function __construct(FileDB $db)
    {
        $this->db = $db;

        $this->loadMenus();
    }


    /**
     * Get all menus
     *
     * @return array
     */
    public function getMenus()
    {
        return array_values($this->menus);
    }


    /**
     * Get a menu by key
     *
     * @param  string $key
     * @return Menu|null
     */
    public function getMenuByKey($key)
    {
        return $this->getMenuById($this->menuKeys[$key] ?? null);
    }


    /**
     * Get a menu by id
     *
     * @param  integer $id
     * @return Menu|null
     */
    public function getMenuById($id)
    {
        return $this->menus[$id] ?? null;
    }


    /**
     * Update a menu
     *
     * @param  string $id
     * @param  array  $data
     * @return Menu|null
     */
    public function updateMenu($id, array $data)
    {
        if (!$menu = $this->menus[$id] ?? null) {
            return false;
        }

        $data = array_replace($menu->toArray(['id']), $data);

        if ($this->db->menus->where('id', $id)->update($data) < 1) {
            return false;
        }

        $this->loadMenus();
        return $this->menus[$id] ?? false;
    }


    /**
     * Add a new menu
     *
     * @param  Menu   $menu
     * @return Menu|null
     */
    public function createMenu(Menu $menu)
    {
        if (!$id = $this->db->menus->insert($menu->toArray(['id']))) {
            return false;
        }

        $this->loadMenus();
        return $this->menus[$id] ?? false;
    }


    /**
     * Delete a menu
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteMenu($id)
    {
        return $this->db->menus->where('id', $id)->delete() > 0;
    }


    /**
     * Load menus
     */
    protected function loadMenus()
    {
        $menus = $this->db->menus->get();
        $menus = Menu::make($menus, 'id');

        if (!is_array($menus)) {
            // No menus exists
            return;
        }

        $this->menus = $menus;

        // Create the key => id index and set the correct page urls
        foreach ($menus as $menu) {
            $this->menuKeys[$menu->key] = $menu->id;

            $items = [];
            foreach ($menu->items as $item) {
                if ($item['page_id'] && !$page = $this->db->pages->find($item['page_id'])) {
                    // THe linked page doesn't exist
                    continue;
                }

                $item['link']        = $item['page_id'] ? $page['uri'] : $item['link'];
                $item['page_status'] = $item['page_id'] ? $page['status'] : 'published';
                $items[] = MenuItem::make($item);
            }
            $menu->items = $items;
        }
    }
}
