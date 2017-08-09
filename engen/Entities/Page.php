<?php namespace Engen\Entities;

class Page extends \Enstart\Entity\Entity
{
    protected $_params = [
        'id'        => null,
        'title'     => null,
        'slug'      => null,
        'key'       => null,
        'uri'       => null,
        'template'  => 'page',
        'status'    => 'published',
        'level'     => 0,
        'order'     => 99,
        'parent_id' => null,
        'is_home'   => 0,
        'content'   => [],
        'created'   => 0,
        'updated'   => 0,
    ];

    public function content($key, $default = null)
    {
       if (!$key) {
            return $default;
        }

        $content  =& $this->_params['content'];
        $keys  = explode('.', $key);

        foreach ($keys as $test) {
            $direct = implode('.', $keys);

            // Check for a direct match, containing dot
            if (is_array($content) && array_key_exists($direct, $content)) {
                return $content[$direct];
            }

            if (!is_array($content) || !array_key_exists($test, $content)) {
                // No hit, return the default
                return $default;
            }

            $content =& $content[$test];
            array_shift($keys);
        }

        return $content;
    }
}
