<label class="checkbox">
<input type="checkbox" 
       id="{{$name}}"
       name="{{ $name }}" 
       @if ($value) 
           checked="checked" 
       @endif

       @if ($disabled)
            disabled="disabled"
       @endif

       value = '1'
       >
<i></i>{{__cms($caption)}}</label>
