
<input type="text" 
       id="{{ $prefix . $name }}"
       value="{{$value}}" 
       name="{{$name}}" 
       class="form-control datepicker timePicker" >
       
<span class="input-group-addon form-input-icon">
    <i class="fa fa-calendar"></i>
</span>

@if (isset($comment) && $comment)
  <div class="note">
      {{$comment}}
  </div>
@endif
<script>
jQuery(document).ready(function() {
    jQuery(".timePicker").datetimepicker({
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        //dateFormat: "",
        timeOnly: true,
        timeFormat: 'HH:mm',
        //showButtonPanel: true,
        regional: ["ru"],
        onClose: function (selectedDate) {}
    });
});
</script>