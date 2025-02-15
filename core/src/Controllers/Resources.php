<?php

namespace EvolutionCMS\Controllers;

use EvolutionCMS\Interfaces\ManagerTheme\PageControllerInterface;
use EvolutionCMS\Interfaces\ManagerTheme\TabControllerInterface;

class Resources extends AbstractResources implements PageControllerInterface
{
    protected string $view = 'page.resources';

    /**
     * Don't change tab index !!!
     */
    protected array $tabs = [
        0 => Resources\Templates::class,
        1 => Resources\Tv::class,
        2 => Resources\Chunks::class,
        3 => Resources\Snippets::class,
        4 => Resources\Plugins::class,
        5 => Resources\Modules::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function canView(): bool
    {
        return true;
    }

    public function getParameters(array $params = []): array
    {
        $activeTab = 0;
        $tabs = [];
        $tab = $this->needTab();

        if ($tab === 0) {
            $tab = key($this->tabs);
        }

        foreach ($this->tabs as $tabN => $tabClass) {
            if (($tabController = $this->makeTab($tabClass, $tabN)) !== null) {
                if ((string) $tab !== (string) $tabN) {
                    $tabController->setNoData();
                } else {
                    $activeTab = $tabController->getTabName();
                }
                $tabs[$tabController->getTabName()] = $tabController;
            }
        }

        return array_merge(compact('tabs'), parent::getParameters($params), compact('activeTab'));
    }

    protected function makeTab($tabClass, int $index = null): ?TabControllerInterface
    {
        $tabController = null;
        if (class_exists($tabClass) &&
            is_a($tabClass, TabControllerInterface::class, true)
        ) {
            $tabController = new $tabClass($this->managerTheme);
            $tabController->setIndex($index);
            if (!$tabController->canView()) {
                $tabController = null;
            }
        }

        return $tabController;
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $params = []): string
    {
        if (!is_ajax() || ($tab = $this->needTab()) === null) {
            return parent::render($params);
        }

        $index = array_search($tab, $this->tabs, true);
        $tabController = $this->makeTab($this->tabs[$tab], $index);
        if (($index !== false && $tabController !== null)) {
            return $tabController->render(
                $tabController->getParameters()
            );
        }

        return '';
    }

    protected function needTab()
    {
        return get_by_key(
            $_GET
            ,
            'tab'
            ,
            0
            ,
            function ($val) {
                return is_numeric($val) && array_key_exists($val, $this->tabs);
            }
        );
    }
}
