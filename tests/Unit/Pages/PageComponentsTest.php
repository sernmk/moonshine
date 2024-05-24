<?php

use MoonShine\Collections\ComponentsCollection;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\Fragment;
use MoonShine\Components\Layout\Box;
use MoonShine\Components\Layout\LineBreak;
use MoonShine\Components\Modal;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\Tabs\Tab;
use MoonShine\Components\Tabs\Tabs;
use MoonShine\Fields\Field;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Fields\StackFields;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Tests\Fixtures\Resources\TestResource;

uses()->group('core');

beforeEach(function (): void {
    $this->data = Box::make([
        FormBuilder::make()->fields([
            Tabs::make([
                Tab::make([
                    LineBreak::make()->name('line-break'),
                    FormBuilder::make()->name('inner-form')->fields([
                        Switcher::make('Switcher'),
                        StackFields::make()->fields([
                            Text::make('Text'),
                            Text::make('Email'),
                        ]),
                        HasOne::make('HasOne', resource: new TestResource()),
                    ]),

                ]),
                Tab::make([
                    TableBuilder::make()
                        ->name('first-table'),

                    TableBuilder::make()
                        ->name('second-table'),
                ]),
            ]),
        ])->name('parent-form'),

        TableBuilder::make()
            ->name('parent-table'),

        Modal::make(
            'Test Modal',
            components: ComponentsCollection::make([
                FormBuilder::make()->fields([
                    Fragment::make([
                        HasOne::make('HasModal', 'has_modal', resource: new TestResource()),
                    ]),
                ])->name('form-in-modal'),
            ])
        ),
    ])->name('block');

    $this->collection = ComponentsCollection::make([
        $this->data,
    ]);
});

it('find table', function () {
    expect($this->collection->findTable('second-table'))
        ->toBeInstanceOf(TableBuilder::class)
        ->getName()
        ->toBe('second-table');
});

it('only forms', function () {
    expect($this->collection->onlyForms())
        ->toHaveCount(3)
        ->each->toBeInstanceOf(FormBuilder::class);
});

it('only tables', function () {
    expect($this->collection->onlyTables())
        ->toHaveCount(3)
        ->each->toBeInstanceOf(TableBuilder::class);
});

it('only fields', function () {
    expect($this->collection->onlyFields())
        ->toHaveCount(5)
        ->each->toBeInstanceOf(Field::class);
});

it('find form', function () {
    expect($this->collection->findForm('inner-form'))
        ->toBeInstanceOf(FormBuilder::class)
        ->getName()
        ->toBe('inner-form');
});

it('find field', function () {
    expect($this->collection->onlyFields()->findByColumn('switcher'))
        ->toBeInstanceOf(Switcher::class)
        ->getNameAttribute()
        ->toBe('switcher');
});

it('find by name', function () {
    expect($this->collection->findByName('line-break'))
        ->toBeInstanceOf(LineBreak::class)
        ->getName()
        ->toBe('line-break');
});

it('find component in modal', function () {
    expect($this->collection->findByName('form-in-modal'))
        ->toBeInstanceOf(FormBuilder::class)
        ->getName()
        ->toBe('form-in-modal');
});

it('find has field in modal', function () {
    expect(
        $this->collection
        ->onlyFields()
        ->onlyHasFields()
        ->findByColumn('has_modal')
    )
        ->not()
        ->toBeNull();
});

it('form fields without outside', function () {
    expect($this->collection->onlyFields()->formFields(withOutside: false)->onlyFields())
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Field::class);
});

it('form fields with outside', function () {
    expect($this->collection->onlyFields()->formFields()->onlyFields())
        ->toHaveCount(5)
        ->each->toBeInstanceOf(Field::class);
});

it('fields only outside', function () {
    expect($this->collection->onlyFields()->onlyOutside())
        ->toHaveCount(2)
        ->each->toBeInstanceOf(HasOne::class);
});

it('form fields only outside', function () {
    expect($this->collection->onlyFields()->formFields()->onlyOutside())
        ->toHaveCount(2)
        ->each->toBeInstanceOf(HasOne::class);
});

it('except element', function () {
    expect($this->collection->exceptElements(fn ($element) => $element instanceof FormBuilder)->first())
        ->getFields()->first()
        ->toBeInstanceOf(TableBuilder::class);
});
