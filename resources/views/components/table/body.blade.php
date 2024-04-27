@props([
    'rows',
    'hasActions' => false,
    'vertical' => false,
    'editable' => false,
    'preview' => false,
    'simple' => false,
    'hasClickAction' => false,
])
@foreach($rows as $row)
    <tr {{ $row->trAttributes($loop->index) }} data-row-key="{{ $row->getKey() }}">
        @if(!$preview && $hasActions)
            <td {{ $row->tdAttributes($loop->index, 0)
                ->merge(['class' => 'w-10 text-center']) }}
                @if($vertical) width="5%" @endif
            >
                <x-moonshine::form.input type="checkbox"
                     autocomplete="off"
                     @change="actions('row', $id('table-component'))"
                     name="items[{{ $row->getKey() }}]"
                     class="tableActionRow"
                     ::class="$id('table-component') + '-tableActionRow'"
                     value="{{ $row->getKey() }}"
                />
            </td>
        @endif

        @if($vertical && !$preview)
            <td
                {{ $row->tdAttributes($vertical ? 0 : $loop->parent->index, 0 + $hasActions)->merge(['class' => 'space-y-3']) }}
            >
                @foreach($row->getFields() as $index => $field)
                    {!! $field !!}
                @endforeach
            </td>
        @else
            @foreach($row->getFields() as $index => $field)
                @if($vertical) <tr {{ $row->trAttributes($index) }}>
                    <td {{ $row->tdAttributes($index, 0) }}>
                        {{$field->getLabel()}}
                    </td>
                    @endif

                    <td {{ $vertical
                            ? $row->tdAttributes($index, 1)
                            : $row->tdAttributes($loop->parent->index, $index + $hasActions) }}
                        @if(!$vertical && $hasClickAction)
                            :class="'cursor-pointer'"
                            @click.stop="rowClickAction"
                        @endif
                    >
                        {!! $field !!}
                    </td>

                    @if($vertical)
                </tr>
                @endif
            @endforeach
        @endif

        @if(!$preview && $row->getActions()->isNotEmpty())
            <td {{ $row->tdAttributes($loop->index, $row->getFields()->count() + $hasActions) }}
                @if($vertical) width="5%" @endif
            >
                <x-moonshine::table.actions
                    :simple="$simple"
                    :actions="$row->getActions()"
                />
            </td>
        @endif
    </tr>
@endforeach
