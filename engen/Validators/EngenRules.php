<?php namespace Engen\Validators;

use Enstart\App;
use Maer\Validator\Rules\Ruleset;

class EngenRules extends Ruleset
{
    protected $app;


    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function ruleNoTrailingWhiteSpace($input)
    {
        if (trim($input) === $input) {
            return true;
        }

        return "The field %s cannot start or end with white spaces";
    }


    public function ruleSlug($slug)
    {
        if (preg_match('/^([\w\-]+)$/', $slug) === 1) {
            return true;
        }

        return "Slugs can only contain alphanumeric characters, underscores and dashes.";
    }


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


    public function rulePageKey($key)
    {
        if (preg_match('/^([\w\-]+)$/', $key) === 1) {
            return true;
        }

        return "Keys can only contain alphanumeric characters, underscores and dashes.";
    }


    public function ruleUniquePageKey($key, $pageId = null)
    {
        $page = $this->app->pages->getPageByKey($key);

        return !$page || $page->id == $pageId
            ? true
            : "There already is a page with this key";
    }


    public function ruleMenuKey($key)
    {
        if (preg_match('/^([\w\-]+)$/', $key) === 1) {
            return true;
        }

        return "Keys can only contain alphanumeric characters, underscores and dashes.";
    }


    public function ruleUniqueMenuKey($key, $menuId = null)
    {
        $menu = $this->app->menus->getMenuByKey($key);

        return !$menu || $menu->id == $menuId
            ? true
            : "There already is a menu with this key";
    }
}
