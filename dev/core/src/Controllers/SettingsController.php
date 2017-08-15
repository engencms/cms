<?php namespace Engen\Controllers;

class SettingsController extends BaseController
{
    public function __construct()
    {
        $this->addBreadCrumb([
            'Settings' => $this->router->getRoute('engen.settings'),
        ]);
    }


    /**
     * Show edit settings form
     *
     * @return string
     */
    public function editSettings()
    {
        return $this->views->render("admin::settings/edit");
    }


    /**
     * Add/Update settings
     *
     * @return JsonEntity
     */
    public function saveSettings()
    {
        $response = $this->makeJsonEntity();

        if (!$this->csrf->validateToken($this->request->post('token'), 'edit-settings')) {
            return $response->setError('Invalid token. Please update page and try again.');
        }

        $site = $this->request->post('site', []);
        if (!is_array($site)) {
            return $response->setError('Invalid content for site settings');
        }

        $this->settings->updateSettings($site, 'site');

        return $response->setMessage('Settings updated');
    }
}
