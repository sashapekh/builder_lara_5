@if (isset($def['mode']) && $def['mode'] == 'new')
    <a class="btn btn-default btn-sm" href="?edit={{ $row['id'] }}">
        <i class="fa fa-pencil"></i>
    </a>
@else
    <li>
        <a onclick="TableBuilder.getEditForm({{$row['id']}}, $(this));"><i class="fa fa-pencil"></i> {{ __cms($def['caption'])}}</a>
    </li>
@endif