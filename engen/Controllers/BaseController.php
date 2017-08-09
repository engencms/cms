<?php namespace Engen\Controllers;

use Enstart\Controller\Controller;

class BaseController extends Controller
{
    protected function addBreadCrumb($label, $uri = null)
    {
        $this->breadCrumbs->add('engen', $label, $uri);
    }
}
