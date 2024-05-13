
<article class="{{$modelCard->size}}"  style="margin-bottom: 20px">
    <div class="jarviswidget" data-widget-colorbutton="false" data-widget-sortable="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
            <h2>{{$modelCard->title}}</h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget content -->
            <div class="widget-body padding">
                <div style="text-align: right">
                    <select name="range" data-model="{{get_class($modelCard)}}" data-card-id="card{{$k}}">
                        @foreach($modelCard->ranges() as $range => $rangeTitle)
                            <option value="{{$range}}">{{$rangeTitle}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <strong style="font-size:30px;" class="value_current">{{$modelCard->calculate()['current']}}</strong>
                </div>
                <div class="value_difference" style="padding-top: 5px">
                    {{$modelCard->calculate()['difference']}}
                </div>
            </div>
        </div>
    </div>
    <!-- end widget -->
</article>
