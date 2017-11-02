<?php namespace Engen\Controllers;

use Engen\Entities\Menu;

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


    /**
     * Show menu list
     *
     * @return string
     */
    public function showNew()
    {
        return $this->views->render("admin::menus/edit", [
            'menu' => new Menu,
        ]);
    }


    /**
     * Add/Update menu
     *
     * @return JsonEntity
     */
    public function saveMenu()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-menu')) {
            return $response->setError('Invalid token. Please update page and try again.');
        }

        $id    = $this->request->post('id');
        $tmp   = $this->request->post('item', []);
        $menu  = $this->request->post('menu');
        $menu  = [
            'name' => $menu['name']      ?? null,
            'key'  => $menu['key']       ?? null,
        ];

        $items = [];
        if ($tmp) {
            foreach ($tmp['label'] as $i => $value) {
                $type = $tmp['type'][$i];
                $items[] = [
                    'label'   => $value,
                    'type'    => $type,
                    'page_id' => $type == "page" ? $tmp['page_id'][$i] : null,
                    'link'    => $type == "custom" ? $tmp['link'][$i] : null,
                    'target'  => !empty($tmp['target'][$i]) ? $tmp['target'][$i] : null,
                ];
            }
        }

        $result = $this->validator->menu($menu, $id);
        if ($result !== true) {
            return $response->setErrors($result)
                ->setMessage('validation_error');
        }

        foreach ($items as $item) {
            $result = $this->validator->menuItem($item);
            if ($result !== true) {
                return $response->setErrors($result)
                    ->setMessage('validation_error');
            }
        }

        $menu['items'] = $items;

        if ($id) {
            if (!$this->menus->updateMenu($id, $menu)) {
                return $response->setError('Error updating menu');
            }
        } else {
            if (!$menu = $this->menus->createMenu(new Menu($menu))) {
                return $response->setError('Error creating menu');
            }

            $id = $menu->id;
        }

        $this->session->setFlash('success', 'Menu saved');

        return $response->setData($this->router->getRoute('engen.menus.edit', [$id]));
    }


    /**
     * Delete a menu
     *
     * @return JsonEntity
     */
    public function deleteMenu()
    {
        $response = $this->makeJsonEntity();

        $id    = $this->request->post('ref');
        $token = $this->request->post('token');

        if (!$id) {
            return $response->setError('Invalid id');
        }

        if (!$this->csrf->validateToken($token, 'delete-menu')) {
            return $response->setError('Invalid call');
        }

        if (!$this->menus->deleteMenu($id)) {
            return $response->setError('Could not delete the menu');
        }

        $this->session->setFlash('success', 'Menu successfully deleted.');

        return $response->setData($this->router->getRoute('engen.menus'));
    }
}
