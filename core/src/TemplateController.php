<?php

namespace EvolutionCMS;

abstract class TemplateController implements \EvolutionCMS\Interfaces\TemplateController
{
    private $view = '';
    private $viewData = [];

    public final function getViewData(): array
    {
        return $this->viewData;
    }

    public final function addViewData(array $data)
    {
        $this->viewData = array_merge($this->viewData, $data);
    }

    public final function getView(): string
    {
        return $this->view;
    }

    public final function setView(string $view)
    {
        $this->view = $view;
    }

    public function process()
    {

    }

    public final function __get($property)
    {
        if (!empty($property) && array_key_exists($property, $this->viewData)) {
            return $this->viewData[$property];
        }
    }

    public final function __set($property, $value)
    {
        if (!empty($property)) {
            $this->viewData[$property] = $value;
        }
    }
}

