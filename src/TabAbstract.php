<?php

namespace Spirling\WpAdminPages;

/**
 * Class TabAbstract
 *
 * @package Spirling\WpAdminPages
 */
abstract class TabAbstract
{

    /**
     * @var TabbedPageAbstract
     */
    protected $page;

    /**
     * @var string
     */
    protected $uri;

    /**
     * TabAbstract constructor.
     *
     * @param TabbedPageAbstract $page
     */
    public function __construct(TabbedPageAbstract $page)
    {
        $this->page = $page;
    }

    public function getUri()
    {
        if (is_null($this->uri)) {
            $pageTabs = $this->page->getTabs();
            $this->uri = $this->page->getUri();
            if (array_shift($pageTabs) !== $this) {
                $this->uri .= '&tab=' . $this->getSlug();
            }
        }
        return $this->uri;
    }

    public function getPage() {
        return $this->page;
    }

    /**
     * Get tab slug
     *
     * @return string
     */
    abstract public function getSlug();

    /**
     * Get tab name
     *
     * @return string
     */
    abstract public function getTitle();

    /**
     * Renders tab page
     */
    abstract public function render();

    /**
     * Load tab
     */
    abstract public function load();

}