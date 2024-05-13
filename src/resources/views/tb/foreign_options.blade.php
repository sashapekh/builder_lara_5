@if (count($options))
    @foreach($options as $k => $option)
        <option value="{{$k}}" {{$k == $selected ? "selected" : ""}}>{{$option}}</option>
    @endforeach
@endif