
<tr id-row="{{ $row['id'] }}" id="sort-{{ $row['id'] }}">
    @if (isset($def['options']['is_sortable']) && $def['options']['is_sortable'])
        <td class="tb-sort" style="cursor:s-resize;">
            <i class="fa fa-sort"></i>
        </td>
    @endif

    @if (isset($def['multi_actions']))
        <td>
            <label class="checkbox multi-checkbox">
                <input type="checkbox" value="{{$row['id']}}" name="multi_ids[]" /><i></i>
            </label>
        </td>
    @endif

    @foreach ($def['fields'] as $ident => $field)
        <?php $field = $controller->getField($ident) ?>
        @if (!$field->getAttribute('hide_list'))
            <td  width="{{ $field->getAttribute('width') }}" class="{{ $field->getAttribute('class') }} unselectable">
                @if ($field->getAttribute('fast-edit'))
                    {!! $field->getListValueFastEdit($row, $ident) !!}
                @elseif($field->getAttribute('result_show'))
                    {!! strip_tags($field->getReplaceStr($row), "<a><span><img><br>") !!}
                @elseif($field->getAttribute('no_strip_tags'))
                    {!! $field->getListValue($row) !!}
                @else
                    <span>{!! strip_tags($field->getListValue($row), "<a><span><img><br>") !!}</span>
                @endif
            </td>
        @endif
    @endforeach

    {!! $controller->view->fetchActions($row) !!}
</tr>
