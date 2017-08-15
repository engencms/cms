<?php namespace App\Controllers;

use Engen\Entities\Page;

class HomeController extends BaseController
{
    /**
     * Generate and show a page
     *
     * @param  string $uri
     * @return string
     */
    public function generate($uri = '')
    {
        $uri  = '/' . trim($uri, '/');
        if (!$page = $this->pages->getPageByUri($uri)) {
            return $this->notFoundError();
        }

        if ($page->status != 'published') {
            return $this->notFoundError();
        }

        $this->views->addData(['page' => $page]);

        return $this->views->render("templates/{$page->template}");
    }


    /**
     * Preview a page
     *
     * @return string
     */
    public function preview()
    {
        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-page')) {
            return $this->notFoundError();
        }

        $info = $this->request->post('info', []);

        if (!$info || !is_array($info)) {
            return $this->notFoundError();
        }

        $page    = new Page($info);
        $content = $this->request->post('field', []);

        $page->content = is_array($content)
            ? $content
            : [];

        $this->views->addData(['page' => $page]);

        return $this->views->render("templates/{$page->template}");
    }
}
