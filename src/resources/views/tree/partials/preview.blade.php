@if ($active)
    <li><a href="{{ $item->getUrl() }}?show=1" target="_blank"><i class="fa fa-eye"></i> {{__cms($caption)}} </a></li>
@endif