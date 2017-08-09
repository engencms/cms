<?php namespace App\Controllers;

use Engen\Entities\Page;
use Enstart\Controller\Controller;

class BaseController extends Controller
{
    public function notFoundError(array $content = [])
    {
        $page = new Page([
            'title'   => $content['title'] ?? '404',
            'content' => [
                'body' => 'Page not found',
            ]
        ]);

        $this->views->addData(['page' => $page]);

        return $this->response->make(
            $this->views->render('404'),
            404
        );
    }
}
