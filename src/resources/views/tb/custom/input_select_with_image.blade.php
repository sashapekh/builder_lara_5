<label class="select">
    <input type="hidden" name="{{ $name }}" value="{{ $selected }}" id="{{"option_with_image_" . $name}}" class="hidden-input">
    <div class="custom-dropdown">
        <div class="selected-option">
            @foreach ($options as $option)
                @if ($option['value'] == $selected)
                    <img src="{{ $option['image'] }}" class="option-image" alt="{{ __cms($option['name']) }}"> {{ $option['name'] }}
                @endif
            @endforeach
        </div>
        <div class="dropdown-content">
            @foreach ($options as $option)
                <div class="dropdown-item" data-value="{{ $option['value'] }}" data-image="{{ $option['image'] }}">
                    <img src="{{ $option['image'] }}" class="option-image" alt="{{ $option['name'] }}"> {{ $option['name'] }}
                    <div class="hover-image">
                        <img src="{{ $option['image'] }}" alt="{{ $option['name'] }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <i></i>
</label>

<!-- Custom CSS -->
<style>
    .custom-dropdown {
        position: relative;
        display: inline-block;
        width: 200px;
    }

    .selected-option {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #fff;
    }

    .selected-option img.option-image {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        z-index: 1;
        width: 100%;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        position: relative;
    }

    .dropdown-item:hover {
        background-color: #f1f1f1;
    }

    .dropdown-item img.option-image {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .hover-image {
        display: none;
        position: absolute;
        top: 50%;
        left: 110%;
        transform: translateY(-50%);
        z-index: 2;
        border: 1px solid #ccc;
        background-color: #fff;
        padding: 5px;
        box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);
    }

    .hover-image img {
        max-width: 800px;
        max-height: 800px;
    }

    .dropdown-item:hover .hover-image {
        display: block;
    }
</style>

<script>
    $(document).ready(function(){
        $('.selected-option').on('click', function() {
            $('.dropdown-content').toggle();
        });

        $('.dropdown-item').on('click', function() {
            var selectedValue = $(this).data('value');
            var selectedImage = $(this).data('image');
            var displayName = $(this).text();

            // Update hidden input value
            $('#{{"option_with_image_" . $name}}').val(selectedValue);

            // Update the display of the selected option
            var displayHtml = '<img src="' + selectedImage + '" class="option-image" alt="' + displayName + '"> ' + displayName;
            $('.selected-option').html(displayHtml);

            // Hide dropdown content
            $('.dropdown-content').hide();
        });

        // Close the dropdown if clicked outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.custom-dropdown').length) {
                $('.dropdown-content').hide();
            }
        });

        // Trigger initial change to display selected option image on page load
        $('.dropdown-item[data-value="{{ $selected }}"]').trigger('click');
    });
</script>