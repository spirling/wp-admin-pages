<?php

namespace Spirling\WpAdminPages;

/**
 * Class TabbedPageAbstract
 *
 * @package Spirling\WpAdminPages
 */
abstract class TabbedPageAbstract extends PageAbstract
{

    /**
     * @return TabAbstract[]
     */
    abstract public function getTabs();

    protected function getTemplatesDir() {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $tabs = $this->getTabs();
        $currentTab = $this->getCurrentTab();
        if (isset($currentTab)) {
            $page = $this;
            includeAdminTemplate($this->getTemplatesDir() . 'admin/pages/tabs.php', compact('tabs', 'currentTab', 'page'));
            $currentTab->render();
        } else {
            wp_redirect( $this->getUri() );
        }
    }

    /**
     * @return TabAbstract
     */
    protected function getCurrentTab()
    {
        $tabs = $this->getTabs();
        $currentTab = $tabs[0];
        if (array_key_exists('tab', $_GET)) {
            foreach ($tabs as $tab) {
                if ($_GET['tab'] === $tab->getSlug()) {
                    $currentTab = $tab;
                    break;
                }
            }
        }
        return $currentTab;
    }

    /**
     * @inheritDoc
     */
    public function load()
    {
        $currentTab = $this->getCurrentTab();
        $currentTab->load();
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->getCurrentTab()->getTitle();
    }

}