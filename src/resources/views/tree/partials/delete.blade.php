@if ($active)
<li>
    <a onclick="Tree.doDelete('{{ $item->id }}', this);" class="node-del-{{$item->id}}" style="color: red">
        <i class="fa fa-times"></i>
        {{__cms($caption)}}
    </a>
</li>
@endif