<ul>
    @foreach($item->children()->get() as $child)
        @if ($child->children()->count())
            <li data-id="{{$child->id}}" data-parent-id="{{$child->parent_id}}" @if(in_array($child->id, $parentIDs))  class="jstree-open" @endif>
                {{$child->title}}
                @include('admin::tree.node_children', array('item' => $child))
            </li>
        @else
            <li data-id="{{$child->id}}" data-parent-id="{{$child->parent_id}}" @if(in_array($child->id, $parentIDs)) class="jstree-open" @endif>
                @include('admin::tree.node', array('item' => $child))
            </li>
        @endif
    @endforeach
</ul>


