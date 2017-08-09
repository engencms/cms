<?php namespace App\Controllers;

class HomeController extends BaseController
{
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
}
