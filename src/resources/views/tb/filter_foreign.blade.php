<select name="filter[{{ $name }}]" class="form-control input-small">
    <option value="">{{__cms('Все')}}</option>

    @if ($recursive)
        @foreach ($options as $value => $caption)
            {!!$caption!!}
        @endforeach
    @else

        @foreach ($options as $value => $caption)
            <option value="{{ $value }}" {{($value == $selected) ? "selected" : ""}}>{{ __cms($caption) }}</option>
        @endforeach

    @endif
</select>
