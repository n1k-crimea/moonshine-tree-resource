@props([
    'resource',
    'item',
    'items',
    'buttons',
])
<li
    data-id="{{ $item->getKey() }}"
    {{--@if($resource->wrapable())--}}
    x-data="{tree_show_{{ $item->getKey() }}: $persist(true).as('tree_resource_{{ $item->getKey() }}')}"
    {{--@endif--}}
>
    <x-moonshine::box class="shadow-none" >
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="@if($resource->sortable()) handle @endif flex justify-start items-center gap-4">
                @if($resource->sortable())
                    <x-moonshine::icon class="cursor-pointer" icon="heroicons.arrows-pointing-out" />
                @endif

                @if($item->publish)
                    <div class="h-4 w-4 rounded-full bg-green-500" title="Опубликовано" ></div>
                @else
                    <div class="h-4 w-4 rounded-full bg-red-500" title="Не опубликовано" ></div>
                @endif

                {{--                @if($item->parent_id == null || $item instanceof App\Models\CatalogRuSoftware || $item instanceof App\Models\CatalogOtherDevice)--}}

                <div class="@if($resource->sortable()) handle__title @endif flex justify-start items-center gap-4" >
                    @if(false)
                        <div>
                            {{--<x-moonshine::badge color="purple">{{ $item->getKey() }}</x-moonshine::badge>--}}
                            {{ $item->{$resource->column()} }}
                        </div>
                    @else
                        <a href="{{{to_page(page: $resource->formPage(), resource: $resource, params: ['resourceItem' => $item->getKey()])}}}">
                            <span style="color:rgb(0 121 255)">
                                {{ $item->{$resource->column()} }}
                            </span>
                        </a>
                    @endif

                    {!! $resource->itemContent($item) !!}

                    @if($resource->wrapable())
                        <a aria-expanded={{count($item->childrens) > 0 ? "true" : "false"}} aria-controls="tree-list-{{ $item->getKey() }}" class="cursor-pointer transition-transform aria-expanded:rotate-180">
                            <x-moonshine::icon icon="heroicons.chevron-down" />
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex justify-between items-center gap-4">
                <x-moonshine::action-group
                    :actions="$buttons($item)"
                />
            </div>
        </div>
    </x-moonshine::box>

    @if($resource->treeKey())
        <ul
            @if($resource->sortable())
                x-data="sortable('{{ $resource->route('sortable') }}', 'nested')"
            class="dropzone aria-hidden:hidden"
            x-show="tree_show_{{ $item->getKey() }}"
            data-id="{{ $item->getKey() }}"
            data-handle=".handle"
            data-animation="150"
            data-fallbackOnBody="true"
            data-swapThreshold="0.65"
            data-content="Область для перетаскивания"
            @endif
            id="tree-list-{{ $item->getKey() }}"
            aria-hidden={{count($item->childrens) > 0 ? "false" : "true"}}
        >

            @if(isset($items[$item->getKey()]))
                @foreach($items[$item->getKey()] as $inner)
                    <x-moonshine-tree::tree.item
                        :items="$items"
                        :item="$inner"
                        :resource="$resource"
                        :buttons="$buttons"
                    />
                @endforeach
            @endif
        </ul>
    @endif
</li>
