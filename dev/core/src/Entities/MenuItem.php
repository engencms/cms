<?php namespace Engen\Entities;

class MenuItem extends \Enstart\Entity\Entity
{
    protected $_params = [
        'label'       => null,
        'link'        => null,
        'target'      => null,
        'page_id'     => null,
        'page_status' => 'published',
    ];
}
