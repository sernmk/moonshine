<?php

declare(strict_types=1);

namespace MoonShine\UI\Components;

use MoonShine\Core\Contracts\CastedData;
use MoonShine\UI\Collections\ActionButtons;
use MoonShine\UI\Collections\ComponentsCollection;
use MoonShine\UI\Collections\MoonShineRenderElements;
use MoonShine\UI\Contracts\Components\HasComponents;

/**
 * @method static static make(array $actions = [])
 */
final class ActionGroup extends MoonShineComponent implements HasComponents
{
    protected string $view = 'moonshine::components.action-group';

    public function __construct(protected array|ActionButtons $actions = [])
    {
        parent::__construct();
    }

    public function fill(?CastedData $data = null): self
    {
        $this->actions = $this->getActions()->fill($data);

        return $this;
    }

    public function getActions(): ActionButtons
    {
        return is_array($this->actions)
            ? ActionButtons::make($this->actions)
            : $this->actions;
    }

    public function add(ActionButton $item): self
    {
        $this->actions = $this->getActions();

        $this->actions->add($item);

        return $this;
    }

    public function addMany(iterable $items): self
    {
        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    public function prepend(ActionButton $item): self
    {
        $this->actions = $this->getActions();

        $this->actions->prepend($item);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [
            'actions' => $this->getActions()->onlyVisible(),
        ];
    }

    public function setComponents(iterable $components): static
    {
        $this->actions = $components;

        return $this;
    }

    public function hasComponents(): bool
    {
        return (bool) count($this->actions);
    }

    public function getComponents(): MoonShineRenderElements
    {
        return ComponentsCollection::make($this->actions);
    }
}
