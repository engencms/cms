<?php namespace Engen\Services;

use Engen\Entities\Field;

class FieldsCollection
{
    protected $fields;

    public function register(Field $field)
    {
        $this->fields[$field->key] = $field;
    }

    public function getField($key)
    {
        return $this->fields[$key] ?? null;
    }

    public function getFields($sort = false)
    {
        if ($sort) {
            $fields = $this->fields;
            ksort($fields);
            return $fields;
        }

        return $this->fields;
    }

    public function getFieldView($key)
    {
        return $this->fields[$key]->view ?? 'admin::fields/none' ;
    }
}
