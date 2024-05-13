<div class="{{$fieldEdit}}">
    {!! $pageEditor->t($field) !!}
</div>

{!! Minify::stylesheet(array(
    '/packages/vis/builder/js/plugin/editor_floala/css/froala_editor.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/froala_style.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/code_view.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/colors.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/emoticons.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/image_manager.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/image.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/line_breaker.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/table.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/char_counter.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/video.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/fullscreen.min.css',
    '/packages/vis/builder/js/plugin/editor_floala/css/plugins/file.min.css',
    ))
 !!}

{!! Minify::javascript(
    array('/packages/vis/builder/js/plugin/editor_floala/js/froala_editor.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/align.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/code_beautifier.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/code_view.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/colors.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/file.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/emoticons.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/draggable.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/font_size.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/font_family.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/image.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/image_manager.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/line_breaker.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/link.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/lists.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/paragraph_format.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/paragraph_style.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/video.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/table.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/url.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/entities.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/char_counter.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/inline_style.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/quote.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/plugins/save.min.js',
          '/packages/vis/builder/js/plugin/editor_floala/js/languages/ru.js',
     ))
!!}
<script>

    var option =  {
        toolbarInline: true,
        alwaysVisible: true,
        imageUploadURL: '/admin/upload_image?_token=' + $("meta[name=csrf-token]").attr("content"),
        imageManagerDeleteURL: "/admin/delete_image?_token=" + $("meta[name=csrf-token]").attr("content"),
        heightMin: 100,
        fileUploadURL: "/admin/upload_file?_token=" + $("meta[name=csrf-token]").attr("content"),
        imageManagerLoadURL: "/admin/load_image?_token=" + $("meta[name=csrf-token]").attr("content"),
        imageDeleteURL: "/admin/delete_image?_token=" + $("meta[name=csrf-token]").attr("content"),
        language: 'ru',
        imageEditButtons: ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize', 'crop'],
    };
    $('.{{$fieldEdit}}').froalaEditor(option);

    $('.{{$fieldEdit}}').on('froalaEditor.contentChanged', function (e, editor) {
        var textEditor = $(this).froalaEditor('html.get');

        $.post("/admin/quick_edit", {
            id : "{{$pageEditor->id}}",
            model: "{{get_class($pageEditor)}}",
            text : textEditor,
            field : "{{$pageEditor->t_fild($field)}}" },
                function(data){});

    });
</script>