<div class="modal-body">

    <form id="edit_form_{{$def['db']['table']}}" class="smart-form" method="post" action="/admin/handle/{{$definitionName}}" novalidate="novalidate">

        @if (!isset($def['position']))
            <fieldset style="{{ request('edit') ? '' : 'padding:0;' }}">

            @include('admin::tb.modal_form_edit_field_simple')
            
            @if (!$is_blank)
                <input type="hidden" name="id" value="{{ $row['id'] }}" />
            @endif
            </fieldset>
        
        @else
            
            <ul class="nav nav-tabs bordered">
                @foreach ($def['position']['tabs'] as $title => $fields)
                    <li @if ($loop->first) class="active" @endif><a href="#etabform-{{$def['db']['table']}}-{{$loop->index}}" data-toggle="tab">{{ __cms($title) }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content padding-10">
                @foreach ($def['position']['tabs'] as $title => $fields)
                    <div class="tab-pane @if ($loop->first) active @endif" id="etabform-{{$def['db']['table']}}-{{$loop->index}}">
                        <div class="table-responsive">
                            <fieldset style="padding:0">

                                @include('admin::tb.modal_form_edit_field_tabbed')

                                @if (!$is_blank)
                                    <input type="hidden" name="id" value="{{ $row['id'] }}" />
                                @endif
                            </fieldset>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    
    </form>
</div>

<div class="modal-footer">
    <button onclick="$('#edit_form_{{$def['db']['table']}}').submit();" type="button" class="btn btn-success btn-sm">
        <span class="glyphicon glyphicon-floppy-disk"></span> {{__cms('Сохранить')}}
    </button>
    <button onclick="TableBuilder.doClosePopup('{{$def['db']['table']}}')" type="button" class="btn btn-default close_button">
       {{__cms('Отмена')}}
    </button>
</div>
