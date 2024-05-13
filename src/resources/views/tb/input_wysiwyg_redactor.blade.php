  <div class="no_active_froala">
      <textarea class="text_block" name="{{ $name }}" toolbar = "{{$toolbar ? : "fullscreen, bold, italic, underline, strikeThrough, subscript, superscript, fontFamily, fontSize,  color, emoticons, inlineStyle, paragraphStyle,  paragraphFormat, align, formatOL, formatUL, outdent, indent, quote, insertHR, insertLink, insertImage, insertVideo, insertFile, insertTable, undo, redo, clearFormatting, selectAll, html"}}"

            inlineStyles = '{{ $inlineStyles ? json_encode($inlineStyles) : ""}}'

            options = '{{ $options ? json_encode($options) : ""}}'>{{ $value  }}</textarea>
  </div>
  @if (isset($comment) && $comment)
        <div class="note">
            {{$comment}}
        </div>
  @endif