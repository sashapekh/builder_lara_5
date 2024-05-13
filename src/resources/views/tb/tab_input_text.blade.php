<section class="{{$className}}">
    <div class="tab-pane active">
                
        <ul class="nav nav-tabs tabs-pull-right">
            <label class="label pull-left" style="line-height: 32px;">{{__cms($caption)}}</label>
            @foreach ($tabs as $tab)
                <li class="{{$loop->first ? 'active' : ''}}">
                    <a href="#{{$pre . $name . $tab['postfix']}}" data-toggle="tab">{{__cms($tab['caption'])}}</a>
                </li>
            @endforeach
        </ul>
        
        <div class="tab-content padding-5">
            @foreach ($tabs as $tab)
                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{$pre . $name . $tab['postfix']}}">
                    <div style="position: relative;">
                        <label class="input">
                             <input type="{{$custom_type ? $custom_type : 'text'}}"
                               value="{{{ $tab['value'] }}}" 
                               name="{{ $name . $tab['postfix']}}" 
                               placeholder="{{{$tab['placeholder']}}}"
                               @if ($mask)
                                    data-mask="{{$mask}}"
                               @endif
                               class="dblclick-edit-input form-control input-sm unselectable">
                        </label>
                       @if (isset($comment) && $comment)
                           <div class="note">
                               {{$comment}}
                           </div>
                       @endif

                    </div>
                </div>
            @endforeach
            
        </div>

    </div>
</section>
