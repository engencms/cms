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

        // Create the key => id index
        foreach ($menus as $menu) {
            $this->menuKeys[$menu->key] = $menu->id;
        }

        // Get items and put them in th right menu
        $items = $this->db->menu_items->orderBy('order', 'asc')->get();

        foreach ($items as $item) {
            if (!array_key_exists($item['menu_id'], $this->menus)) {
                // The menu doesn't exist
                continue;
            }

            if ($item['page_id'] && !$page = $this->db->pages->find($item['page_id'])) {
                // THe linked page doesn't exist
                continue;
            }

            $item['link']        = $item['page_id'] ? $page['uri'] : $item['link'];
            $item['page_status'] = $item['page_id'] ? $page['status'] : 'published';
            $this->menus[$item['menu_id']]->addItem(MenuItem::make($item));
        }
    }
}
