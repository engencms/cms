<?php namespace Engen\Services;

use Closure;
use Engen\Repos\PagesInterface;

class Parsers
{
    /**
     * Registered parsers
     * @var array
     */
    protected $parsers = [];

    /**
     * @var PagesInterface
     */
    protected $pages;


    /**
     * @param DataInterface $pages
     */
    public function __construct(PagesInterface $pages)
    {
        $this->pages = $pages;
    }


    /**
     * Register a parser
     *
     * @param string  $name
     * @param Closure $parser
     */
    public function registerParser($name, Closure $parser)
    {
        $this->parsers[$name] = $parser;
    }


    /**
     * @param  string $name
     * @param  array  $args
     * @return string
     */
    public function __call($name, $args)
    {
        if (!array_key_exists($name, $this->parsers)) {
            throw new \Exception("Unknown parser: " . $name);
        }

        $text = call_user_func_array($this->parsers[$name], $args);
        return $this->parseShortCodes($text);
    }


    /**
     * Get a registered parser
     *
     * @param  string $name
     * @return Parser
     */
    public function parser($name)
    {
        return $this->parsers[$name] ?? null;
    }


    /**
     * Parse short codes
     *
     * @param  string $text
     * @return string
     */
    protected function parseShortCodes($text)
    {
        $pages = $this->pages;

        $text = preg_replace_callback('/\[page-url\:([^\]]+)\]/', function ($matches) use ($pages) {
            return $pages->getPageUriByKey(trim($matches[1]));
        }, $text);

        return $text;
    }
}
