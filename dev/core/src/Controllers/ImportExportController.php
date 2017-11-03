<?php namespace Engen\Controllers;

class ImportExportController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Import/Export' => $this->router->getRoute('engen.import-export'),
        ]);
    }

    /**
     * Show the import / export view
     *
     * @return string
     */
    public function view()
    {
        return $this->views->render('admin::import-export/view');
    }
}
