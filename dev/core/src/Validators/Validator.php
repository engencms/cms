<?php namespace Engen\Validators;

use Enstart\Validator\ValidatorInterface;

class Validator
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;


    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


    /**
     * Validate page data
     *
     * @param  array  $data
     * @param  string $pageId
     * @return true|array  Returns true on success and an error of errors on fail
     */
    public function page(array $data, $pageId = null)
    {
        $parentId = $data['parent_id'] ?? null;
        $pageId   = $pageId ?? 0;

        $rules = [
            'title'   => ['required', 'minLength:1', 'noTrailingWhiteSpace'],
            'slug'    => ['required', 'minLength:1', 'slug', "uniqueSlug:{$pageId},{$parentId}"],
            'key'     => ['required', 'minLength:1', 'pageKey', "uniquePageKey:{$pageId}"],
            'is_home' => ['in:0,1'],
            'status'  => ['in:published,draft'],
        ];

        $v = $this->validator->make($data, $rules);

        return $v->passes() ?: $v->errors()->all();
    }


    /**
     * Validate menu data
     *
     * @param  array  $data
     * @param  string $id
     * @return true|array  Returns true on success and an error of errors on fail
     */
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


    /**
     * Validate menu item data
     *
     * @param  array  $item
     * @return true|array  Returns true on success and an error of errors on fail
     */
    public function menuItem(array $item)
    {
        $rules = [
            'label'   => ['required', 'minLength:1'],
        ];

        $v = $this->validator->make($item, $rules);

        return $v->passes() ?: $v->errors()->all();
    }


    /**
     * Validate user data
     *
     * @param  array  $data
     * @param  string $id
     * @return true|array  Returns true on success and an error of errors on fail
     */
    public function user(array $data, $id = null)
    {
        $id       = $id ?? 0;

        $rules = [
            'username'   => ['required', 'minLength:1', 'noTrailingWhiteSpace', "uniqueUserUsername:{$id}"],
            'email'      => ['required', 'email', "uniqueUserEmail:{$id}"],
            'first_name' => ['required', 'minLength:1', 'noTrailingWhiteSpace'],
            'last_name'  => ['allowEmpty', 'minLength:1', 'noTrailingWhiteSpace'],
        ];

        $p1 = $data['p1'] ?? null;

        if (!$id || !empty($p1)) {
            $rules['password']         = ['required', 'noTrailingWhiteSpace', 'password'];
            $rules['password_confirm'] = ['required', 'same:password'];
        }

        $v = $this->validator->make($data, $rules);

        return $v->passes() ?: $v->errors()->all();
    }


    /**
     * Validate page data
     *
     * @param  array  $data
     * @param  string $blockId
     * @return true|array  Returns true on success and an error of errors on fail
     */
    public function block(array $data, $blockId = null)
    {
        $blockId = $blockId ?? 0;

        $rules = [
            'name'    => ['required', 'minLength:2', 'noTrailingWhiteSpace'],
            'key'     => ['required', 'minLength:1', 'noTrailingWhiteSpace', "uniqueBlockKey:{$blockId}"],
        ];

        $v = $this->validator->make($data, $rules);

        return $v->passes() ?: $v->errors()->all();
    }
}
