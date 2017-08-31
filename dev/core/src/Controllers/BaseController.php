<?php namespace Engen\Controllers;

use Enstart\Controller\Controller;

class BaseController extends Controller
{
    protected function addBreadCrumb($label, $uri = null)
    {
        $this->breadCrumbs->add('engen', $label, $uri);
    }

    /**
     * Reorder content
     *
     * @param  array $content
     * @return array
     */
    protected function reorderFields(array $content)
    {
        $new = [];

        foreach ($content as $key => $value) {
            if (is_array($value) && count($value) > 0 && !array_key_exists(0, $value)) {
                $new[$key] = $this->fixPostArray($value);
                continue;
            }

            $new[$key] = $value;
        }

        return $new;
    }


    /**
     * Fix post arrays to be key => value
     *
     * @param  array  $data
     * @return array
     */
    protected function fixPostArray(array $data)
    {
        $keys  = array_keys($data);
        $fixed = [];

        foreach ($data[$keys[0]] as $index => $value) {
            $item = [];
            foreach ($keys as $key) {
                $item[$key] = $data[$key][$index] ?? null;
            }

            $fixed[] = $item;
        }

        return $fixed;
    }
}
