
<div class="widget-toolbar" role="menu">
    <!-- add: non-hidden - to disable auto hide -->

    <div class="btn-group">
    
    <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
        <i class="fa fa-upload"></i>
        {{ __cms($def['caption']) }}
    </button>
    
    <ul class="dropdown-menu pull-right" style="min-width: {{ $def['width'] ?? '260' }}px; padding-bottom: 0;">
        
        <form id="tb-export-form" class="smart-form">
            <fieldset style="padding: 12px 12px 0;">
                @if (isset($def['date_range_field']))
                <section>
                    <div class="row">
                        <div class="col col-6">
                            <input placeholder="От" type="text" id="export-date-from" name="d[from]" class="form-control input-small datepicker">
                        </div>
                        <div class="col col-6">
                            <input placeholder="До" type="text" id="export-date-to" name="d[to]" class="form-control input-small datepicker">
                        </div>
                    </div>
                </section>
                @endif
                
                <section>
                    <div class="row">
                        <div class="col col-12">
                            @foreach ($fields as $name => $caption)
                            <label class="checkbox">
                                <input type="checkbox" name="b[{{ $name }}]">
                                <i></i>
                                {{ __cms($caption) }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </section>
            </fieldset>
        </form>
        
        <div class="btn-group btn-group-justified">
            @foreach ($def['buttons'] as $type => $info)
                <a href="javascript:void(0);" 
                   onclick="TableBuilder.doExport('{{ $type }}' {{isset($info['url_load']) ? ", '" . $info['url_load'] . "'" : '' }});"
                   class="btn btn-default">
                        {{ $info['caption'] }}
                </a>
            @endforeach
        </div>
        
    </ul>
    
    </div>
</div>

<script type="text/javascript">
$('#tb-export-form').bind('click', function(e) {
    e.stopPropagation()
});

$("#export-date-from, #export-date-to").datepicker({
    changeMonth: true,
    numberOfMonths: 1,
    prevText: '<i class="fa fa-chevron-left"></i>',
    nextText: '<i class="fa fa-chevron-right"></i>',
    dateFormat: "yy-mm-dd",
    //showButtonPanel: true,
    regional: ["ru"],
    onClose: function (selectedDate) {}
});

</script>
