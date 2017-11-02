<?php namespace Engen\Entities;

class MenuItem extends \Enstart\Entity\Entity
{
    protected $_params = [
        'label'       => null,
        'type'        => null,
        'link'        => null,
        'page_id'     => null,
        'page_status' => 'published',
        'target'      => null,
    ];
}
