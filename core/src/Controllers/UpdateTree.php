<?php

namespace EvolutionCMS\Controllers;

use EvolutionCMS\Interfaces\ManagerTheme\PageControllerInterface;
use EvolutionCMS\Models\ClosureTable;
use EvolutionCMS\Models\SiteContent;

class UpdateTree extends AbstractController implements PageControllerInterface
{
    protected string $view = 'page.update_tree';

    /**
     * {@inheritdoc}
     */
    public function canView(): bool
    {
        return true;
    }

    public function process(): bool
    {
        $this->parameters['count'] = SiteContent::query()->count();

        $this->parameters['finish'] = 0;
        if (isset($_POST['start'])) {
            $start = microtime(true);
            $result = SiteContent::query()->where('parent', 0)->get();
            ClosureTable::query()->truncate();
            while ($result->count() > 0) {
                $parents = [];
                foreach ($result as $item) {
                    $descendant = $item->getKey();
                    $ancestor = isset($item->parent) ? $item->parent : $descendant;
                    $item->closure = new ClosureTable();
                    $item->closure->insertNode($ancestor, $descendant);
                    $parents[] = $descendant;
                }
                $result = SiteContent::query()->whereIn('parent', $parents)->get();
            }

            $this->parameters['end'] = round((microtime(true) - $start), 2);
            $this->parameters['finish'] = 1;
        }

        return true;
    }

}
