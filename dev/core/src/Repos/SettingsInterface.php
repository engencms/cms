<?php namespace Engen\Repos;

interface SettingsInterface
{
    /**
     * Get all settings
     *
     * @return array
     */
    public function getSettings();


    /**
     * Get a setting value by it's key
     *
     * @param  string $key
     * @param  mixed  $fallback
     * @return mixed
     */
    public function getSetting($key, $fallback = null);


    /**
     * Update settings
     *
     * @param  array  $data
     * @param  string $type
     * @return boolean
     */
    public function updateSettings(array $data, $type);
}
