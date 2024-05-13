<style>
    .dataTables_length .form-control,  #table-log_filter .form-control{
        display: inline-block;
        margin: 0 5px;
    }

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 table-container jarviswidget jarviswidget-color-blue">
            @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
            @else
                <header>
                    <span class="widget-icon"> <i class="fa  fa-file-text"></i> </span>
                    <h2> Логи сайта </h2>
                    <div class="btn-group" style="float: right">
                        <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                            <span>{{$current_file}}</span>  <i class="fa fa-caret-down"></i>
                        </button>
                        <ul class="dropdown-menu js-status-update pull-right">

                            @foreach($files as $file)
                                <li class="@if ($current_file == $file) active @endif">
                                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                       class="list-group-item">
                                        {{$file}}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </header>
                <table id="table-log" class="table  table-hover table-bordered ">
                    <thead>
                    <tr>
                        <th>Уровень</th>
                        {{--   <th>Context</th>--}}
                        <th>Дата/время</th>
                        <th>Описание</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($logs as $key => $log)
                        <tr data-display="stack{{{$key}}}">
                            <td class="text-{{{$log['level_class']}}}">
                                <span class="fa fa-{{$log['level_img']}}" aria-hidden="true"></span> &nbsp;{{$log['level']}}
                            </td>
                            {{--  <td class="text">{{$log['context']}}</td>--}}
                            <td class="date">{{{$log['date']}}}</td>
                            <td class="text" style="text-align: left">
                                {{$log['text']}}
                                @if (isset($log['in_file'])) <br/>{{$log['in_file']}}@endif
                                @if ($log['stack'])
                                    <div class="stack" id="stack{{{$key}}}"
                                         style="display: none; white-space: pre-wrap;">{{ trim($log['stack']) }}
                                    </div>@endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif
            <div class="p-3" style="padding: 10px">
                @if($current_file)
                    <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}">
                        <span class="fa fa-download"></span>
                        Скачать файл
                    </a>
                    {{--  -
                      <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}"><span
                            class="fa fa-trash"></span> Delete file</a>
                      @if(count($files) > 1)
                        -
                        <a id="delete-all-log" href="?delall=true"><span class="fa fa-trash"></span> Delete all files</a>
                      @endif--}}
                @endif
            </div>
        </div>
    </div>
</div>
<!-- jQuery for Bootstrap -->

<!-- Datatables -->

<script>

        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });

        $('#table-log').DataTable({
            "order": [2, 'desc'],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            },
            "language": {
                "lengthMenu": "Показать _MENU_ записей",
                "zeroRecords": "Ничего не найдено",
                "info": "Показано _PAGE_ из _PAGES_",
                "infoEmpty": "No records available",
                "search": "поиск",
                "infoFiltered": "(filtered from _MAX_ total records)",
            }
        });
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });

</script>