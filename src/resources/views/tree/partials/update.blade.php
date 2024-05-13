@if ($active)
    <li><a onclick="Tree.showEditForm('{{ $item->id }}');"><i class="fa fa-pencil"></i> {{__cms($caption)}}</a></li>
@endif
