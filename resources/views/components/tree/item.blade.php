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
    <x-moonshine::box>
        <div class="flex justify-between items-center gap-4">
            <div class="@if($resource->sortable()) handle @endif flex justify-start items-center gap-4">
                @if($resource->sortable())
                    <x-moonshine::icon class="cursor-pointer" icon="heroicons.arrows-up-down" />
                @endif
                @if($item->publish)
                    <x-moonshine::icon icon="heroicons.outline.check-circle" />
                @endif
                {{--                @if($item->parent_id == null || $item instanceof App\Models\CatalogRuSoftware || $item instanceof App\Models\CatalogOtherDevice)--}}
                @if(false)
                    <div class="font-bold">
                        {{--<x-moonshine::badge color="purple">{{ $item->getKey() }}</x-moonshine::badge>--}}
                        {{ $item->{$resource->column()} }}
                    </div>
                @else
                    <div class="font-bold">
                        <a href="{{{to_page(page: $resource->formPage(), resource: $resource, params: ['resourceItem' => $item->getKey()])}}}">
                            <span style="color:rgb(0 121 255)">
                                {{ $item->{$resource->column()} }}
                            </span>
                        </a>
                    </div>
                @endif

                @if($resource->wrapable() && $item->parent_id == null)
                    <a aria-expanded={{count($item->childrens) > 0 ? "true" : "false"}} class="cursor-pointer" @click.stop="tree_show_{{ $item->getKey() }} = !tree_show_{{ $item->getKey() }}">
                        <x-moonshine::icon icon="heroicons.arrow-down-on-square" />
                    </a>
                @endif

                {!! $resource->itemContent($item) !!}
            </div>

            <div class="flex justify-between items-center gap-4">
                <x-moonshine::action-group
                    :actions="$buttons($item)"
                />
            </div>
        </div>
        @if($resource->treeKey() && $item->parent_id == null)
            <ul
                @if($resource->sortable())
                    x-data="sortable('{{ $resource->route('sortable') }}', 'nested')"
                class="dropzone"
                x-show="tree_show_{{ $item->getKey() }}"
                data-id="{{ $item->getKey() }}"
                data-handle=".handle"
                data-animation="150"
                data-fallbackOnBody="true"
                data-swapThreshold="0.65"
                @endif
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
    </x-moonshine::box>
</li>
