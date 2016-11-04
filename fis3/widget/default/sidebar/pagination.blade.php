<nav class="pull-right">
  <ul class="pagination">
    <li><a href="{{$pagination['prev_page_url']}}">&laquo;</a></li>
    @if($pagination['current_page'] > $pagination['last_page'])
        {{$pagination['current_page'] = $pagination['last_page']}}
    @endif
    @if ($pagination['last_page'] < 5)
        @for($k=1;$k<=$pagination['last_page'];$k++)
            @if($pagination['current_page'] == $k)
                <li class="active"><a href="?page={{$k}}">{{$k}}</a></li>
            @else 
                <li class=""><a href="?page={{$k}}">{{$k}}</a></li>
            @endif
        @endfor
    @elseif($pagination['last_page'] - $pagination['current_page'] <=2)
        @for($k=$pagination['last_page']-4;$k<=$pagination['last_page'];$k++)
            @if($pagination['current_page'] == $k)
                <li class="active"><a href="?page={{$k}}">{{$k}}</a></li>
            @else 
                <li class=""><a href="?page={{$k}}">{{$k}}</a></li>
            @endif
        @endfor
    @else 
        @for($k=$pagination['current_page']-2;$k<=$pagination['current_page']+2;$k++)
            @if($pagination['current_page'] == $k)
                <li class="active"><a href="?page={{$k}}">{{$k}}</a></li>
            @else 
                <li class=""><a href="?page={{$k}}">{{$k}}</a></li>
            @endif
        @endfor
    @endif
    <li><a href="{{$pagination['next_page_url']}}">&raquo;</a></li>
    <span style="margin-top: 20px;">共{{$pagination['total']}}条数据;第{{$pagination['current_page']}}页;共{{$pagination['last_page']}}页</span>
  </ul>
</nav>