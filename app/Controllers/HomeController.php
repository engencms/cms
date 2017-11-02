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
}
