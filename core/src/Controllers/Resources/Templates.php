<?php

namespace EvolutionCMS\Controllers\Resources;

use EvolutionCMS\Controllers\AbstractResources;
use EvolutionCMS\Interfaces\ManagerTheme\TabControllerInterface;
use EvolutionCMS\Models\Category;
use EvolutionCMS\Models\SiteTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

//'actions'=>array( 'edit'=>array(16,'edit_template'), 'duplicate'=>array(96,'new_template'), 'remove'=>array(21,'delete_template') ),
class Templates extends AbstractResources implements TabControllerInterface
{
    protected string $view = 'page.resources.templates';

    /**
     * {@inheritdoc}
     */
    public function getTabName($withIndex = true): string
    {
        if ($withIndex) {
            return 'tabPlugins-' . $this->getIndex();
        }

        return 'tabTemplates';
    }

    /**
     * {@inheritdoc}
     */
    public function canView(): bool
    {
        return evo()->hasAnyPermissions([
            'new_template',
            'edit_template',
        ]);
    }

    protected function getBaseParams(): array
    {
        return array_merge(
            parent::getParameters(),
            [
                'tabPageName' => $this->getTabName(false),
                'tabIndexPageName' => $this->getTabName(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(array $params = []): array
    {
        $params = array_merge($this->getBaseParams(), $params);

        if ($this->isNoData()) {
            return $params;
        }

        return array_merge([
            'categories' => $this->parameterCategories(),
            'outCategory' => $this->parameterOutCategory(),
        ], $params);
    }

    protected function parameterOutCategory(): Collection
    {
        return SiteTemplate::lockedView()
            ->where('category', 0)
            ->orderBy('templatename')
            ->get();
    }

    protected function parameterCategories(): Collection
    {
        return Category::with('templates')
            ->whereHas('templates', function (Builder | SiteTemplate $builder) {
                return $builder->lockedView();
            })
            ->orderBy('rank')
            ->get();
    }
}
