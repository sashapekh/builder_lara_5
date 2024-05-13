<script>
    $("#create_form_{{$def['db']['table']}}").validate({
        rules: {
            @foreach ($def['fields'] as $ident => $options)
            @php
                $field = $controller->getField($ident);
            @endphp

            {!! $field->getClientsideValidatorRules() !!}
            @endforeach
        },
        messages: {
            @foreach ($def['fields'] as $ident => $options)
            @php
                $field = $controller->getField($ident);
            @endphp

            {!! $field->getClientsideValidatorMessages() !!}
            @endforeach
        },
        submitHandler: function(form) {
            TableBuilder.doCreate("#create_form_{{$def['db']['table']}}", '{{request('foreign_field_id')}}', '{!! request('foreign_attributes') !!}');
        }
    });
</script>