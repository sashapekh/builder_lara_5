<select name="filter[{{ $name }}]" class="form-control input-small">
    <option></option>
    @foreach ($options as $value => $caption)
        <option value="{{ $value }}"  {{($value === (int)$filter && $filter !== '') ? "selected" : ""}} >{{ __cms($caption) }}</option>
    @endforeach
</select>