<select name="filter[{{ $name }}]" class="form-control input-small">
    <option></option>
    @foreach ($options as $value => $caption)
        @if ($value === $filter)
            <option value="{{ $value }}" selected>{{ __cms($caption) }}</option>
        @else
            <option value="{{ $value }}">{{ __cms($caption) }}</option>
        @endif
    @endforeach
</select>