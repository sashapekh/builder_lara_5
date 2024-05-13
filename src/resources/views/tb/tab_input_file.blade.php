<section class="{{$className}}">
    <div class="tab-pane active">
        <ul class="nav nav-tabs tabs-pull-right">
            <label class="label pull-left" style="line-height: 32px;">{{__cms($caption)}}</label>
            @foreach ($tabs as $tab)
                <li class="{{$loop->first ? 'active' : ''}}">
                    <a href="#{{$name . $tab['postfix']}}" data-toggle="tab">{{__cms($tab['caption'])}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content padding-5">
            @foreach ($tabs as $tab)
                <div class="tab-pane {{$loop->first ? 'active' : ''}}" id="{{$name . $tab['postfix']}}">
                    <div style="position: relative;">
                        @include('admin::tb.input_file', [
                            'name' => $name . $tab['postfix'],
                            'value' => $tab['value'],
                            'is_multiple' => $is_multiple,
                            'accept' => $accept,
                            'comment' => $comment,
                            'source' => $tab['source'] ?? []
                        ])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
