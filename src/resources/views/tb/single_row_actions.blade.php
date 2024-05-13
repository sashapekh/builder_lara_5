<td style="width: 80px">
 @if(count($def['actions']))
  <div style="display: inline-block">
       <div class="btn-group  pull-right">
            <a class="btn dropdown-toggle btn-default"  data-toggle="dropdown">
                <i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">

                @if (isset($def['actions']['custom']))
                       @foreach ($def['actions']['custom'] as $button)
                           {!! $actions->fetch('custom', $row, $button) !!}
                       @endforeach
                @endif

                @foreach($def['actions'] as $actionName => $actionArray)
                    @if ($actionName == 'insert' || $actionName == 'filter' || $actionName == 'custom' ||
                     (isset($actionArray['check']) && !$actionArray['check']()))
                       @continue
                    @endif
                    {!! $actions->fetch($actionName, $row) !!}
                @endforeach

            </ul>
        </div>
    </div>
  @endif
</td>
