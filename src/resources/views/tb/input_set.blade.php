
<select multiple="multiple" name="{{ $name }}[]" class="dblclick-edit-input form-control input-small unselectable">
    @foreach ($options as $value => $caption)
        @if (in_array($value, $selected))
            <option value="{{ $value }}" selected>{{ __cms($caption) }}</option>
        @else
            <option value="{{ $value }}">{{ __cms($caption) }}</option>
        @endif
    @endforeach
</select>
