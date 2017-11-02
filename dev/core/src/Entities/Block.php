<?php namespace Engen\Entities;

class Block extends \Enstart\Entity\Entity
{
    protected $_params = [
        'id'          => null,
        'name'        => null,
        'key'         => null,
        'definition'  => null,
        'content'     => [],
        'created'     => 0,
        'updated'     => 0,
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
