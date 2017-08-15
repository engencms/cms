<?php namespace Engen\Entities;

class User extends \Enstart\Entity\Entity
{
    protected $_params = [
        'id'          => null,
        'username'    => null,
        'password'    => null,
        'email'       => null,
        'first_name'  => null,
        'last_name'   => null,
        'reset_token' => null,
        'reset_date'  => 0,
        'status'      => 'active',
        'created'     => 0,
        'updated'     => 0,
    ];
}
