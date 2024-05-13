<label class="input">
    <input id="{{$name}}"
           name="{{$name}}"
           value="{{ $value ? : $default }}"
           type="text"
           class="form-control input-sm unselectable">

     @if (isset($comment) && $comment)
       <div class="note">
           {{$comment}}
       </div>
     @endif
</label>
<script>
jQuery(document).ready(function() {
    $('#{{$name}}').colorpicker().on('changeColor.colorpicker', function(event){
       $("#{{$name}}").val(event.color.toHex());
     });
});
</script>