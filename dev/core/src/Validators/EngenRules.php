<?php namespace Engen\Validators;

use Enstart\App;
use Maer\Validator\Rules\Ruleset;

class EngenRules extends Ruleset
{
    /**
     * @var App
     */
    protected $app;


    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }


    /**
     * Check if the input starts or ends wihth white spaces
     *
     * @param  string $input
     * @return true|string
     */
    public function ruleNoTrailingWhiteSpace($input)
    {
        if (trim($input) === $input) {
            return true;
        }

        return "The field %s cannot start or end with white spaces";
    }


    /**
     * Validate a url slug
     *
     * @param  string $slug
     * @return true|string
     */
    public function ruleSlug($slug)
    {
        if (preg_match('/^([\w\-]+)$/', $slug) === 1) {
            return true;
        }

        return "Slugs can only contain alphanumeric characters, underscores and dashes.";
    }


    /**
     * Checl if the url slug already exists with the same parent
     *
     * @param  string $slug
     * @param  string $pageId
     * @param  string $parentId
     * @return true|string
     */
    public function ruleUniqueSlug($slug, $pageId, $parentId = null)
    {
        $parentId = empty($parentId) ? null : $parentId;

        $pages = $this->app->pages->getPagesWithSlug($slug);

        foreach ($pages as $page) {
            if ($page->id != $pageId && $page->parent_id == $parentId) {
                return "A page with the same slug and parent already exists";
            }
        }

        return true;
    }


    /**
     * Validate a page key
     *
     * @param  string $key
     * @return true|string
     */
    public function rulePageKey($key)
    {
        if (preg_match('/^([\w\-]+)$/', $key) === 1) {
            return true;
        }

        return "Keys can only contain alphanumeric characters, underscores and dashes.";
    }



    /**
     * Check if the page key is unique
     *
     * @param  string $key
     * @param  string $pageId
     * @return true|string
     */
    public function ruleUniquePageKey($key, $pageId = null)
    {
        $page = $this->app->pages->getPageByKey($key);

        return !$page || $page->id == $pageId
            ? true
            : "There's already is a page with this key";
    }


    /**
     * Validate menu key
     *
     * @param  string $key
     * @return true|string
     */
    public function ruleMenuKey($key)
    {
        if (preg_match('/^([\w\-]+)$/', $key) === 1) {
            return true;
        }

        return "Keys can only contain alphanumeric characters, underscores and dashes.";
    }


    /**
     * Check if the menu key is unique
     *
     * @param  string $key
     * @param  string $menuId
     * @return true|string
     */
    public function ruleUniqueMenuKey($key, $menuId = null)
    {
        $menu = $this->app->menus->getMenuByKey($key);

        return !$menu || $menu->id == $menuId
            ? true
            : "There already is a menu with this key";
    }


    /**
     * Check if the username is unique
     *
     * @param  string $username
     * @param  string $id
     * @return true|string
     */
    public function ruleUniqueUserUsername($username, $id = null)
    {
        $user = $this->app->users->getUserByUsername($username);

        return !$user || $user->id == $id
            ? true
            : "The username is already taken";
    }


    /**
     * Check if the user email is unique
     *
     * @param  string $email
     * @param  string $id
     * @return true|string
     */
    public function ruleUniqueUserEmail($email, $id = null)
    {
        $user = $this->app->users->getUserByEmail($email);

        return !$user || $user->id == $id
            ? true
            : "The email address is already registered";
    }


    /**
     * Validate password
     *
     * @param  string $password
     * @return true|string
     */
    public function rulePassword($password)
    {
        return strlen($password) >= 5
            ? true
            : "The password must contain at least 8 characters";
    }


    /**
     * Check if the block key is unique
     *
     * @param  string $key
     * @param  string $blockId
     * @return true|string
     */
    public function ruleUniqueBlockKey($key, $blockId = null)
    {
        $block = $this->app->blocks->getBlockByKey($key);

        return !$block || $block->id == $blockId
            ? true
            : "There's already is a block with this key";
    }
}
