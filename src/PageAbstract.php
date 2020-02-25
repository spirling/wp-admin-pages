<?php

namespace Spirling\WpAdminPages;

/**
 * Class PageAbstract
 *
 * @package Spirling\WpAdminPages
 *
 * @property string $slug
 * @property string $uri
 */
abstract class PageAbstract
{

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $parentSlug;

    /**
     * @var null|array
     */
    protected $childPages;

    /**
     * @param string$name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        $value = null;
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            $value = $this->$getter();
        } elseif (property_exists($this, $name)) {
            $value = $this->$name;
        }
        return $value;
    }

    /**
     * @param string $parentSlug
     */
    public function setParentSlug($parentSlug)
    {
        is_null($this->childPages) and $this->parentSlug = $parentSlug;
    }

    /**
     * @param PageAbstract $page
     */
    public function addChildPage(PageAbstract $page)
    {
        is_null($this->parentSlug) and $this->childPages[get_class($page)] = $page;
    }

    public function getChildPageByClassName($className)
    {
        return $this->childPages[$className];
    }

    /**
     * Add page to menu
     *
     * @param string $parent
     */
    public function addToMenu()
    {
        $title = $this->getTitle();
        if (is_null($this->parentSlug)) {
            $pageHook = add_menu_page(
                $title, // Page title
                $title, // Menu title
                'manage_options', // capability
                $this->getSlug(), // menu slug
                [$this, 'render'] // callback
            );
        } else {
            $pageHook = add_submenu_page(
                $this->parentSlug, // parent
                $title, // Page title
                $title, // Menu title
                'manage_options', // capability
                $this->getSlug(), // menu slug
                [$this, 'render'] // callback
            );
            if (!is_null($this->childPages)) {
                foreach ($this->childPages as $childPage) {
                    $childPage->setParentSlug($this->getSlug());
                    $childPage->addToMenu();
                }
            }
        }
        add_action('load-'.$pageHook, [$this, 'load']);
    }

    /**
     * Returns page URI
     *
     * @return string
     */
    public function getUri()
    {
        if (is_null($this->uri)) {
            $this->uri = admin_url('admin.php?page=' . $this->getSlug());
        }
        return $this->uri;
    }

    /**
     * Get page slug
     *
     * @return string
     */
    abstract public function getSlug();

    /**
     * Get page name
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Calls on page loading
     * It is using for including assets and preloading page functions
     */
    abstract public function load();

    /**
     * Renders page
     */
    abstract public function render();

}