@php
    $full = $rating ? floor($rating) : 0;
    $half = $rating ? (($rating - $full) >= 0.5 ? 1 : 0) : 0;
    $empty = 5 - $full - $half;
@endphp
@for($i = 0; $i < $full; $i++)
<i class="fas fa-star"></i>
@endfor
@if($half)
<i class="fas fa-star-half-alt"></i>
@endif
@for($i = 0; $i < $empty; $i++)
<i class="far fa-star"></i>
@endfor
