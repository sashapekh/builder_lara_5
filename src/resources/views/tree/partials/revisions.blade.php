@if ($active)
    <li><a onclick="TableBuilder.getRevisions({{ $item->id }}, this);" ><i class="fa fa-history"></i> {{__cms($caption)}} </a></li>
@endif
