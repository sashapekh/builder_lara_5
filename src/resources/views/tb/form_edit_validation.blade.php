<script>
    let foreingAttrs = @json(request('foreign_attributes'));

    $("#edit_form_{{$def['db']['table']}}").validate({
        rules: {
            @foreach ($def['fields'] as $ident => $options)
                    <?php
                $field = $controller->getField($ident); ?>

                    {!! $field->getClientsideValidatorRules() !!}
                    @endforeach
        },
        messages: {
            @foreach ($def['fields'] as $ident => $options)
                    <?php
                $field = $controller->getField($ident); ?>

                    {!! $field->getClientsideValidatorMessages() !!}
                    @endforeach
        },
        submitHandler: function (form) {
            {{ $is_tree ? 'Tree' : 'TableBuilder' }}.doEdit(
                    {{$row['id']}},
                "{{$def['db']['table']}}",
                '{{request('foreign_field_id')}}',
                foreingAttrs
            );
        }
    });

</script>
