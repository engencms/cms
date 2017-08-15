<?php namespace Engen\Entities;

class File extends \Enstart\Entity\Entity
{
    protected $_params = [
        'name'      => null,
        'size'      => 0,
        'path'      => null,
        'type'      => null,
        'mime'      => null,
        'typeInfo'  => [],
        'created'   => 0,
        'modified'  => 0,
    ];

    public function size($decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        if ((strlen($this->size) -1) < 1) {
            return '0B';
        }

        $factor = floor((strlen($this->size) - 1) / 3);
        if ($factor == 0) {
            $decimals = 0;
        }
        return sprintf("%.{$decimals}f", $this->size / pow(1024, $factor)) . ' ' . @$size[$factor];
    }

    public function realType()
    {
        return strtolower($this->_params['typeInfo'][0] ?? $this->type);
    }

    public function isRealType($type)
    {
        return strtolower($type) === $this->realType();
    }
}


