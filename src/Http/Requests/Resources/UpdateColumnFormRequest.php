<?php

declare(strict_types=1);

namespace MoonShine\Http\Requests\Resources;

use MoonShine\Contracts\Fields\FieldsWrapper;
use MoonShine\Exceptions\ResourceException;
use MoonShine\Fields\Field;
use MoonShine\Http\Requests\MoonShineFormRequest;
use Throwable;

final class UpdateColumnFormRequest extends MoonShineFormRequest
{
    /**
     * @throws Throwable
     * @throws ResourceException
     */
    public function authorize(): bool
    {
        $this->beforeResourceAuthorization();

        $resource = $this->getResource();

        if (is_null($resource) || is_null($this->getField())) {
            return false;
        }

        if (! in_array(
            'update',
            $resource->getActiveActions(),
            true
        )) {
            return false;
        }

        return $resource->can('update');
    }

    /**
     * @throws Throwable
     */
    public function getField(): ?Field
    {
        $resource = $this->getResource();

        if (\is_null($resource)) {
            return null;
        }

        $data = $resource->getItem();

        if (\is_null($data)) {
            return null;
        }

        $fields = $resource->getIndexFields();
        $fields->each(
            fn (Field $field): Field => $field instanceof FieldsWrapper
                ? $field->resolveFill($data->toArray(), $data)
                : $field
        );

        return $fields
            ->withoutWrappers()->findByColumn(request()->input('field'));
    }

    /**
     * @return array{field: string[], value: string[]}
     */
    public function rules(): array
    {
        return [
            'field' => ['required'],
            'value' => ['present'],
        ];
    }

    protected function prepareForValidation(): void
    {
        request()->merge([
            request()->input('field') => request()->input('value'),
        ]);
    }
}
