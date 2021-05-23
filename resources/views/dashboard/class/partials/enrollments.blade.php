<hr class="light-grey-hr mb-10 mt-0"/>
@if ($enrollments!=null && count($enrollments)>0)
<ul class="list-icons" style="font-size:95%">
@foreach($enrollments as $item)
    <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> 
        {{$item->student->matriculation_number}} - {{$item->student->first_name}} {{$item->student->last_name}}
    </li>
@endforeach
</ul>
@else
No Enrolled Students
@endif
