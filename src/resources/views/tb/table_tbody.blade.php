
@forelse ($rows as $row)
    <?php $row = $row->toArray();?>
    @include('admin::tb.single_row')
@empty
    <tr>
        <td colspan="100%">Пока пусто</td>
    </tr>
@endforelse
