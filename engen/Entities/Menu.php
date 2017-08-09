<?php namespace Engen\Entities;

class Menu extends \Enstart\Entity\Entity
{
    protected $_params = [
        'id'        => null,
        'name'      => null,
        'key'       => null,
        'items'     => [],
    ];

    public function addItem(MenuItem $item)
    {
        $this->_params['items'][] = $item;
    }
}
