@for($i = 1; $i <= 5; ++$i)
    @if($rating >= $i)
        <span class="glyphicon glyphicon-star rating-yes"></span>
    @else
        <span class="glyphicon glyphicon-star rating-no"></span>
    @endif
@endfor
