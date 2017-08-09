<?php namespace Engen\Controllers;

class DashboardController extends BaseController
{
    public function showDashboard()
    {
        return $this->views->render("admin::dashboard/dashboard");
    }
}
