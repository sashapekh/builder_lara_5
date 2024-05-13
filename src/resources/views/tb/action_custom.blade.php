<li>
    <a onclick="TableBuilder.doCustomAction('{{ url(sprintf($def['link'], $row[$def['params'][0]])) }}')" href="javascript:;"><i class="fa fa-{{$def['icon']}}"></i>
    {{ __cms($def['caption'])  }}
    </a>
</li>
