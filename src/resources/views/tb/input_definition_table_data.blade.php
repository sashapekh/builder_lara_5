@php
    function transformStringDefinition($input) {
        // Split the string by underscores
        $words = explode('_', $input);

        // Capitalize each word
        $words = array_map('ucfirst', $words);

        // Join the words without spaces
        $output = implode('', $words);

        return $output;
    }
@endphp


<div class="loader_definition"><i class="fa fa-gear fa-4x fa-spin"></i></div>


<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <td class="col_sort"></td>
        @foreach($arrayDefinitionFields as $name => $field)
            <th>{{$field['caption']}}</th>
        @endforeach
        <th style="width: 10%"></th>
    </tr>
    </thead>
    <tbody>
    @forelse($result as $data)
        <tr data-id="{{$data['id']}}">
            <td class="handle col_sort"><i class="fa fa-sort"></i></td>
            @foreach($arrayDefinitionFields as $name => $field)
                    <?php
                    $nameClass = "Vis\\Builder\\Fields\\".transformStringDefinition($field['type'])."Field";
                    $resultObjectFild = new $nameClass($name, $field, [], [], []);
                    ?>
                <td>{!! $resultObjectFild->getListValueDefinitionPopup($data) !!}</td>
            @endforeach
            <td>
                <div class="btn-group hidden-phone pull-right">
                    <a class="btn dropdown-toggle btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> <i
                                class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a class="edit-definition-li"
                               data-id="{{$data['id']}}"
                               data-id-update="{{$idUpdate}}"><i
                                        class="fa fa-pencil"></i> {{__cms('Редактировать')}}</a></li>
                        <li><a class="delete-definition-li"
                               data-id="{{$data['id']}}"
                               data-id-update="{{$idUpdate}}"
                            ><i
                                        class="fa red fa-times"></i> {{__cms('Удалить')}}</a></li>
                    </ul>
                </div>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="{{count ($arrayDefinitionFields) +1 }}"> {{__cms('Пока пусто')}} </td>
        </tr>
    @endforelse
    </tbody>
</table>


<script>
    const definition_attrs_json = @json($attributes);

    function deleteDefinition(id, idUpdate, attrs) {
        console.log('delete attrs', id, idUpdate, attrs)
        ForeignDefinition.delete(id, idUpdate, attrs);
    }

    function editDefinition(id, idUpdate, attrs) {
        console.log('edit attrs', id, idUpdate, attrs)
        ForeignDefinition.edit(id, idUpdate, attrs);
    }

    // onclick to delete
    $('.delete-definition-li').click(function () {
        deleteDefinition(
            $(this).data('id'),
            $(this).data('id-update'),
            definition_attrs_json
        )
    });

    // onclick to edit
    $('.edit-definition-li').click(function () {
        editDefinition(
            $(this).data('id'),
            $(this).data('id-update'),
            definition_attrs_json
        )
    });
</script>