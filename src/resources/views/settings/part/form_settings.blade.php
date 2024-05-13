   <style>
    .types{
        display: none;
    }
   </style>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
        @if(isset($info->id))
            <h4 class="modal-title" id="modal_form_label">{{__cms('Редактирование')}}</h4>
        @else
            <h4 class="modal-title" id="modal_form_label">{{__cms('Создание')}}</h4>
        @endif
      </div>
      <div class="modal-body">

        <form id="form_page" class="smart-form" enctype="multipart/form-data" method="post" novalidate="novalidate" >
          <fieldset style="padding:0">
                <div class="row">
                  <section class="col col-6">
                    <label class="label" for="title">{{__cms('Название')}}</label>
                    <div style="position: relative;">
                      <label class="input">
                      <input type="text" id="title" value="{{ $info->title ?? '' }}" name="title"
                        class="dblclick-edit-input form-control input-sm unselectable">
                      </input>
                      </label>
                    </div>
                  </section>
                  <section class="col col-6">
                    <label class="label" for="slug">{{__cms('Код(для вставки)')}}</label>
                    <div style="position: relative;">
                      <label class="input">
                      <input type="text" id="slug" value="{{ $info->slug ?? '' }}"  name="slug"
                        {{ isset($info->slug) ? "readonly" : "" }}
                        class="dblclick-edit-input form-control input-sm unselectable">
                      </input>
                      </label>
                    </div>
                  </section>
           </div>
            <div class="row">
                 <section class="col" style="float: none">
                     <label class="label">{{__cms('Группа')}}</label>
                     <div style="position: relative;">
                       <label class="select">
                          <select name="group">
                              @foreach($groups as $k=>$el)
                                  <option value="{{$k}}" {{ isset($info->group_type) && $k==$info->group_type?"selected":"" }}>{{__cms($el)}}</option>
                              @endforeach
                          </select>
                          <i></i>
                       </label>
                     </div>
                   </section>
              </div>
            <div class="row">
               <section class="col" style="float: none">
                   <label class="label">{{__cms('Тип')}}</label>
                   <div style="position: relative;">
                     <label class="select">

                        <select name="type" onchange="Settings.typeChange(this)">
                            @foreach($type as $k=>$el)
                                <option value="{{$k}}" {{ isset($info->type) && $k==$info->type?"selected":"" }}>{{__cms($el)}}</option>
                            @endforeach
                        </select>
                        <i></i>
                     </label>
                   </div>
                 </section>
            </div>

             <div class="row">
                <section class="col" style="float: none">
                   @include("admin::settings.partials.type_input")
                   @include("admin::settings.partials.type_textarea")


                    <div class='type_2 types' {!! isset($info->type) && $info->type==2 ? 'style="display: block"' : "" !!}>
                        <label class="label" >{{__cms('Значение')}}</label>
                     <table style="width: 100%" class="sort_table">
                          <tbody>

                           @if(isset($select_info))
                                @foreach($select_info as $el)
                                   <tr class="tr_select_{{$el['id']}}">
                                      <td class="td_mov"></td>
                                      <td>
                                          <label class="input">
                                              <input type="text" value="{{$el['value']}}" name="select[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                          </label>

                                      </td>
                                     <td style="width: 16px; text-align: center">
                                          <a class="delete_select" onclick="Settings.doDeleteSelect({{$el['id']}})"><i class="fa red fa-times"></i></a>
                                     </td>
                                  </tr>
                                @endforeach

                           @endif

                            <tr class="last_tr">
                                <td></td>
                                <td>
                                    <label class="input">
                                        <input type="text" value="" name="select[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                    </label>

                                </td>
                               <td style="width: 16px; text-align: center">

                               </td>
                            </tr>
                           </tbody>
                     </table>

                       <p><a class="add_option" onclick="Settings.addOption(2)">{{__cms('Добавить еще')}}</a></p>
                    </div>
                    <div class='type_3 types' {!! isset($info->type) && $info->type==3 ? 'style="display: block"' : "" !!} >
                     <label class="label" >{{__cms('Значение')}}</label>
                     <table style="width: 100%" class="sort_table">
                          <tbody>

                           @if(isset($select_info))
                                @foreach($select_info as $el)
                                   <tr class="tr_select_{{$el['id']}}">
                                      <td class="td_mov"></td>
                                      <td>
                                          <label class="input col col-6" style="padding-left: 0">
                                              <input type="text" value="{{{$el['value']}}}" name="select21[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                          </label>
                                          <label class="input col col-6" style="padding-left: 0">
                                              <input type="text" value="{{{$el['value2']}}}" name="select22[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                          </label>

                                      </td>
                                     <td style="width: 16px; text-align: center">
                                          <a class="delete_select" onclick="Settings.doDeleteSelect({{$el['id']}})"><i class="fa red fa-times"></i></a>
                                     </td>
                                  </tr>
                                @endforeach

                           @endif

                            <tr class="last_tr">
                                <td></td>
                                <td>
                                    <label class="input col col-6" style="padding-left: 0">
                                        <input type="text" value="" name="select21[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                    </label>
                                    <label class="input col col-6" style="padding-left: 0">
                                        <input type="text" value="" name="select22[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                    </label>
                                    <div class='clear'></div>

                                </td>
                               <td style="width: 16px; text-align: center">

                               </td>
                            </tr>
                           </tbody>
                     </table>

                       <p><a class="add_option2" onclick="Settings.addOption(3)">{{__cms('Добавить еще')}}</a></p>
                    </div>
                    <div class='type_4 types' {!! isset($info->type) && $info->type==4?'style="display: block"':"" !!}>
                        <label class="label" >{{__cms('Значение')}}</label>
                        <div class="input input-file">
                            <span class="button"><input type="file" id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value">{{__cms('Выбрать')}}</span>
                            <input type="text" placeholder="{{__cms('Выбрать файл для загрузки')}}" readonly="">
                        </div>
                        @if(isset($info->value) && isset($info->type) && $info->type==4)
                            <p><a href='{{$info->value}}' target='_blank'>{{$info->value}}</a></p>
                        @endif

                    </div>
                    <div class='type_5 types' {!! isset($info->type) && $info->type==5 ? 'style="display: block"' :"" !!}>
                         <label class="label" >{{__cms('Значение')}}</label>
                         <table style="width: 100%" class="sort_table">
                              <tbody>

                               @if(isset($select_info))
                                    @foreach($select_info as $el)
                                       <tr class="tr_select_{{$el['id']}}">
                                          <td class="td_mov"></td>
                                          <td>
                                              <label class="input col col-4" style="padding-left: 0">
                                                  <input type="text" value="{{$el['value']}}" name="select31[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                              </label>
                                              <label class="input col col-4" style="padding-left: 0">
                                                  <input type="text" value="{{$el['value2']}}" name="select32[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                              </label>
                                              <label class="input col col-4" style="padding-left: 0">
                                                 <input type="text" value="{{$el['value3']}}" name="select33[{{$el['id']}}]" class="dblclick-edit-input form-control input-sm unselectable">
                                              </label>

                                          </td>
                                         <td style="width: 16px; text-align: center">
                                              <a class="delete_select" onclick="Settings.doDeleteSelect({{$el['id']}})"><i class="fa red fa-times"></i></a>
                                         </td>
                                      </tr>
                                    @endforeach

                               @endif

                                <tr class="last_tr">
                                    <td></td>
                                    <td>
                                        <label class="input col col-4" style="padding-left: 0">
                                            <input type="text" value="" name="select31[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                        </label>
                                        <label class="input col col-4" style="padding-left: 0">
                                            <input type="text" value="" name="select32[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                        </label>
                                         <label class="input col col-4" style="padding-left: 0">
                                               <input type="text" value="" name="select33[new][]" class="dblclick-edit-input form-control input-sm unselectable">
                                           </label>

                                        <div class='clear'></div>

                                    </td>
                                   <td style="width: 16px; text-align: center">

                                   </td>
                                </tr>
                               </tbody>
                         </table>

                           <p><a class="add_option3" onclick="Settings.addOption(5)">{{__cms('Добавить еще')}}</a></p>
                        </div>

                    @include("admin::settings.partials.type_textarea_froala")

                    <div class='type_7 types'
                            {!!  isset($info->type) && $info->type==7 ? 'style=display: block' :""!!}
                    >
                          <label class="label" >{{__cms('Значение')}}</label>
                          <label class="toggle" style="padding-right: 51px">
                              <input type="hidden" value="0" name="status">
                              <input type="checkbox" {{isset($info->value) && $info->value == 1 ? "checked" : ""}} value="1" name="status">
                              <i data-swchoff-text="ВЫКЛ" data-swchon-text="ВКЛ"></i>
                          </label>
                    </div>

                </section>
             </div>

          </fieldset>
                <div class="modal-footer">
                  <i class="fa fa-gear fa-41x fa-spin" style="display: none"></i>
                  <button  type="submit" class="btn btn-success btn-sm"> <span class="glyphicon glyphicon-floppy-disk"></span> {{__cms('Сохранить')}} </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"> {{__cms('Отмена')}} </button>
                </div>

                <input type="hidden" name="id" value="{{$info->id ?? '0'}}">
        </form>
      </div>
 <script>
    @if(!isset($info->id))
         $("#form_page [name=title]").keyup(function(){
             $("#form_page [name=slug]").val(slug_gen($("#form_page [name=title]").val()));
         })
    @endif;
 </script>
