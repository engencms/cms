<?php namespace Engen\Controllers;

use Engen\Entities\Block;

class BlocksController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Blocks' => $this->router->getRoute('engen.blocks'),
        ]);
    }


    /**
     * Show block list
     *
     * @return string
     */
    public function showBlocks()
    {
        return $this->views->render("admin::blocks/list");
    }


    /**
     * Show edit block form
     *
     * @param  string $id
     * @return string
     */
    public function editBlock($id)
    {
        $this->addBreadCrumb([
            'Edit' => $this->router->getRoute('engen.blocks.edit', [$id]),
        ]);

        if (!$block = $this->blocks->getBlockById($id)) {
            return $this->routeRedirect('engen.blocks');
        }

        return $this->views->render("admin::blocks/edit", [
            'block'    => $block,
        ]);
    }


    /**
     * Show new block form
     *
     * @return string
     */
    public function newBlock()
    {
        $this->addBreadCrumb([
            'New' => $this->router->getRoute('engen.blocks.new'),
        ]);

        return $this->views->render("admin::blocks/edit", [
            'block' => new Block,
        ]);
    }


    /**
     * Add/Update block
     *
     * @return JsonEntity
     */
    public function saveBlock()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-block')) {
            return $response->setError('Invalid token. Please update the page and try again.');
        }

        $id     = $this->request->post('id');
        $fields = $this->request->post('field', []);
        $info   = [
            'name'       => $this->request->post('name'),
            'key'        => $this->request->post('key'),
            'definition' => $this->request->post('definition'),
        ];

        $result = $this->validator->block($info, $id);
        if ($result !== true) {
            return $response->setErrors($result)
                ->setMessage('validation_error');
        }

         $fields = $this->reorderFields($fields);

        if ($id) {
            if (!$this->blocks->updateBlock($id, $info, $fields)) {
                return $response->setError('Error updating block');
            }
        } else {
            if (!$block = $this->blocks->createBlock(new Block($info), $fields)) {
                return $response->setError('Error creating block');
            }

            $id = $block->id;
        }

        $this->session->setFlash('success', 'Block saved');

        return $response->setData($this->router->getRoute('engen.blocks.edit', [$id]));
    }


    /**
     * Create a unique block key
     *
     * @return JsonEntity
     */
    public function slugifyKey()
    {
        $response = $this->makeJsonEntity();

        $text     = $this->request->get('text');
        $blockId  = $this->request->get('block_id');
        $text     = $this->slugifier->slugify($text);

        $key      = $text;
        $i        = 2;

        while ($block = $this->blocks->getBlockByKey($key)) {
            if ($block->id == $blockId) {
                break;
            }

            $key = $text . '-' . $i;
            $i++;
        }

        return $response->setData($key);
    }
}
