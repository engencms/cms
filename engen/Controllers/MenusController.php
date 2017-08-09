<?php namespace Engen\Controllers;

use Engen\Entities\Menu;
use Engen\Entities\MenuItem;

class MenusController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Menus' => $this->router->getRoute('engen.menus'),
        ]);
    }


    /**
     * Show menu list
     *
     * @return string
     */
    public function showMenus()
    {
        return $this->views->render("admin::menus/list");
    }


    /**
     * Show edit menu form
     *
     * @param  string $id
     * @return string
     */
    public function editMenu($id)
    {
       $this->addBreadCrumb([
            'Edit' => $this->router->getRoute('engen.menus.edit', [$id]),
        ]);

        if (!$menu = $this->menus->getMenuById($id)) {
            return $this->routeRedirect('engen.menus');
        }

        return $this->views->render("admin::menus/edit", [
            'menu' => $menu,
        ]);
    }
}
