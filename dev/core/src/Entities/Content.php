<?php namespace Engen\Entities;

class Content extends \Enstart\Entity\Entity
{
    protected $_params = [
        'content'    => null,
        'definition' => [],
        'field'      => null,
    ];

    public function __toString()
    {
        return $this->_params['content'];
    }

    public function definition($key, $fallback = null)
    {
        return $this->_params['definition'][$key] ?? $fallback;
    }
}
