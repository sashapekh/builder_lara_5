<div class="widget-toolbar" role="menu">
    @if (isset($button['ajax']))
        <a onclick="sendAjax('{{$button['link']}}'{{isset($button['massage_start']) ? ", '" . $button['massage_start'] . "'" : ''}})"
           class="btn btn-xs btn-default"
           @if(isset($button['id'])) id="{{ $button['id'] }}" @endif
        >
            <i class="fa {{isset($button['icon']) && $button['icon'] ? "fa-".$button['icon'] : ""}}"></i>
            {{__cms($button['caption'])}}
        </a>

        <script>
            if (typeof sendAjax != 'function') {
                function sendAjax(link, message_start) {
					if (message_start != undefined) {
						TableBuilder.showSuccessNotification(message_start);
					}

					TableBuilder.showPreloader();

                    $.post(link, {},
                        function(data){
                            if (data.status == 'success') {
                                TableBuilder.showSuccessNotification(data.message);
                            } else {
                                TableBuilder.showErrorNotification(data.message);
                            }

                        }, 'json')
                        .complete(function () {
                            TableBuilder.hidePreloader();
                        });
                }
            }

        </script>
    @else
    <a href="{{$button['link']}}" class="btn btn-xs btn-default" @if(isset($button['id'])) id="{{ $button['id'] }}" @endif>
        <i class="fa {{isset($button['icon']) && $button['icon'] ? "fa-".$button['icon'] : ""}}"></i>
        {{__cms($button['caption'])}}
    </a>
    @endif
</div>