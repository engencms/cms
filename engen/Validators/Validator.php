<?php namespace Engen\Validators;

use Enstart\Validator\ValidatorInterface;

class Validator
{
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function page(array $data, $id = null)
    {
        $parentId = $data['parent_id'] ?? null;
        $id       = $id ?? 0;


        $rules = [
            'title'   => ['required', 'minLength:1', 'noTrailingWhiteSpace'],
            'slug'    => ['required', 'minLength:1', 'slug', "uniqueSlug:{$id},{$parentId}"],
            'key'     => ['required', 'minLength:1', 'pageKey', "uniquePageKey:{$id}"],
            'is_home' => ['in:0,1'],
            'status'  => ['in:published,draft'],
        ];

        $v = $this->validator->make($data, $rules);

        return $v->passes() ?: $v->errors()->all();
    }

    public function menu(array $data, $id = null)
    {
        $id       = $id ?? 0;

        $rules = [
            'name'   => ['required', 'minLength:1', 'noTrailingWhiteSpace'],
            'key'    => ['required', 'minLength:1', 'menuKey', "uniqueMenuKey:{$id}"],
        ];

        $v = $this->validator->make($data, $rules);

        return $v->passes() ?: $v->errors()->all();
    }

    public function menuItem(array $item)
    {
        $rules = [
            'label'   => ['required', 'minLength:1'],
        ];

        $v = $this->validator->make($item, $rules);

        return $v->passes() ?: $v->errors()->all();
    }
}
