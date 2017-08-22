<?php namespace Engen\Controllers;

class PartialsController extends BaseController
{
    /**
     * Show page link selector
     *
     * @return string
     */
    public function pageLinkSelector()
    {
        return $this->views->render("admin::partials/page-link-selector", [
            'data' => $this->request->get()->all(),
        ]);
    }


    /**
     * Show file selector
     *
     * @return string
     */
    public function fileSelector()
    {
        return $this->views->render("admin::partials/file-selector", [
            'data' => $this->request->get()->all(),
        ]);
    }
}
