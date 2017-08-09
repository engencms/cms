<?php namespace Engen\Entities;

class MenuItem extends \Enstart\Entity\Entity
{
    protected $_params = [
        'id'          => null,
        'label'       => null,
        'link'        => null,
        'target'      => null,
        'page_id'     => null,
        'menu_id'     => null,
        'page_status' => 'published',
        'order'       => 99,
    ];
}
