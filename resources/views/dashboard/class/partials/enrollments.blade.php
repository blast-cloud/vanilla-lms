<ul class="list-icons" style="font-size:95%">
@if ($enrollments!=null && count($enrollments)>0)
@foreach($enrollments as $item)
    <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> 
        {{$item->student->matriculation_number}} - {{$item->student->first_name}} {{$item->student->last_name}}
    </li>
@endforeach
@else
    <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> No Enrolled Students.</li>
@endif
</ul>