@if ($active)
    <li><a onclick="Tree.getCloneForm({{ $item->id }}, {{request("node", 1)}});" ><i class="fa fa-copy"></i> {{__cms($caption)}} </a></li>
@endif
