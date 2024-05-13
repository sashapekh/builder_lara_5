@if (isset($def['cards']))
    <div class="row">
        @foreach ($def['cards'] as $k => $model)
            <div id="card{{$k}}">
                <?php $modelCard = new $model(); ?>
                @if ($modelCard instanceof \Vis\Builder\Services\Value)
                    @include('admin::partials.card_value')
                @elseif ($modelCard instanceof \Vis\Builder\Services\Trend)
                    @include('admin::partials.card_trend')
                @endif
            </div>
        @endforeach
    </div>

@endif
