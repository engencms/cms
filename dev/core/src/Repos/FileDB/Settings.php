<?php namespace Engen\Repos\FileDB;

use Engen\Repos\SettingsInterface;
use Maer\FileDB\FileDB;

class Settings implements SettingsInterface
{
    /**
     * @var FileDB
     */
    protected $db;

    /**
     * @var array
     */
    protected $settings = [];


    /**
     * @param FileDB $db
     */
    public function __construct(FileDB $db)
    {
        $this->db = $db;

        $this->loadSettings();
    }


    /**
     * Get all settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }


    /**
     * Get a setting value by it's key
     *
     * @param  string $key
     * @param  mixed  $fallback
     * @return mixed
     */
    public function getSetting($key, $fallback = null)
    {
        return array_key_exists($key, $this->settings)
            ? $this->settings[$key]
            : $fallback;
    }


    /**
     * Update settings
     *
     * @param  array  $data
     * @param  string $type
     * @return boolean
     */
    public function updateSettings(array $data, $type)
    {
        $db = $this->db->settings;

        foreach ($data as $key => $value) {
            if (isset($this->settings[$key])) {
                $db->where('key', $key)
                    ->where('type', $type)
                    ->update(['value' => $value]);
                continue;
            }

            $db->insert([
                'key'   => $key,
                'value' => $value,
                'type'  => $type
            ]);
        }

        return true;
    }


    /**
     * Load settings
     */
    protected function loadSettings()
    {
        $settings = $this->db->settings->get();

        foreach ($settings as $item) {
            $this->settings[$item['key']] = $item['value'];
        }
    }
}
