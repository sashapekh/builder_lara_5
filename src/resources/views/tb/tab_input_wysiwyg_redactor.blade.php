<section class="{{$className}}">
    <div class="tab-pane active">
        <ul class="nav nav-tabs tabs-pull-right">
            <label class="label pull-left" style="line-height: 32px;">{{__cms($caption)}}</label>
            @foreach ($tabs as $tab)
                <li class="{{$loop->first ? 'active' : ''}}">
                    <a href="#{{$pre .  $name . $tab['postfix']}}" data-toggle="tab">{{__cms($tab['caption'])}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content padding-5">
            @foreach ($tabs as $tab)
                    <div class="tab-pane no_active_froala {{$loop->first ? 'active' : ''}}" id="{{ $pre . $name . $tab['postfix']}}">
                    <textarea name="{{ $name . $tab['postfix'] }}"
                              inlineStyles = '{{ $inlineStyles ? json_encode($inlineStyles) : ""}}'
                              options = '{{ $options ? json_encode($options) : ""}}'
                              toolbar = "{{$toolbar ? : "fullscreen, bold, italic, underline, strikeThrough, subscript, superscript, fontFamily, fontSize, color, emoticons, inlineStyle, paragraphStyle,  paragraphFormat, align, formatOL, formatUL, outdent, indent, quote, insertHR, insertLink, insertImage, insertVideo, insertFile, insertTable, undo, redo, clearFormatting, selectAll, html"}}"
                             class="text_block"

                    >{{ $tab['value']  }}</textarea>
                    @if (isset($comment) && $comment)
                        <div class="note">
                            {{$comment}}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>


