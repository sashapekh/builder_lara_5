<!-- Modal -->
<div class="modal fade modal_form_{{$def['db']['table']}}" id="modal_form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" style="width: 920px" data-width="920px">
        <div class="form-preloader smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-default close_button" style="float: right; margin: 0 5px"  type="button"
                        onclick="TableBuilder.doClosePopup('{{$def['db']['table']}}')"
                > {{__cms('Отмена')}} </button>
                <button class="btn btn-success btn-sm" style="float: right" type="button"
                        onclick="$('#create_form_{{$def['db']['table']}}').submit();">
                     <span class="glyphicon glyphicon-floppy-disk"></span>
                    {{__cms('Сохранить')}}
               </button>
               @if ($def['options']['caption'])
                   <h4 class="modal-title" id="modal_form_label">{{$def['options']['caption']}}: {{__cms('создание')}}</h4>
                @else
                    <h4 class="modal-title" id="modal_form_label">{{__cms('Создание')}}</h4>
                @endif
            </div>
            @include('admin::tb.form_create')
        </div>
    </div>
</div>

@include('admin::tb.form_create_validation')
