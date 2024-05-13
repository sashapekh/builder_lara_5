@if(isset($annotation))
    {!! $annotation !!}
@endif
<div class="widget-box table-builder dataTables_wrapper">
        @include('admin::tb.form')
        @include('admin::tb.table')
        @include('admin::tb.ui_overlay')

        <iframe id="submiter" name="submiter" style="display:none; visibility:hidden;"></iframe>                    
    </div>
</div>

<script type="text/javascript">

    TableBuilder.optionsInit({
        action_url: '{{ $controller->getUrlAction() }}'
    });

    TableBuilder.action_url = '{{ $controller->getUrlAction() }}';
</script>