@if ($field !== $given_field)
<i class="text-gray-500 fas fa-sort"></i>
@elseif ($asc)
<i class="fas fa-sort-up"></i>
@else
<i class="fas fa-sort-down"></i>
@endif