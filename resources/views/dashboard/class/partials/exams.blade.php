@if ($current_user->lecturer_id!=null)
<a href="#" id="btn-show-modify-examination-modal" class="btn btn-xs btn-primary">
    <i class="fa fa-upload" style=""></i> Add New Examination
</a>
<br/>
@endif
@php
    $class_examinations = $classActivities-> get_examination();    
@endphp
<hr class="light-grey-hr mb-10 mt-0"/>

@if ($class_examinations!=null && count($class_examinations)>0)
@foreach($class_examinations as $item)
    @if ($item->course_class_id == $courseClass->id )
        <dl>
            <dt class="mb-0">
                Examination #<span id="spn_exam_{{$item->id}}_num">{{$item->examination_number}}</span> - Exam scheduled for <span id="spn_exam_{{$item->id}}_date">{{ date('Y-m-d', strtotime($item->exam_date)) }} </span> <span id="spn_exam_{{$item->id}}_time">@php echo $timeObj->parse($item->exam_time)->format('h:i A');@endphp </span> - <span id="spn_exam_{{$item->id}}_title">{{$item->title}}</span>
                <span class="text-danger" style="font-size:80%"><br/>
                    Posted on {{ $item->created_at->format('d-M-Y') }} &nbsp;&nbsp;|&nbsp;&nbsp;  Points <span id="spn_exam_{{$item->id}}_max_points">{{ $item->grade_max_points }}</span>, contributes <span id="spn_exam_{{$item->id}}_contrib">{{ $item->grade_contribution_pct }}</span>% to final score.
                </span>
            </dt>
            <dd class="mb-0" style="font-size:85%;">
                <span id="spn_exam_{{$item->id}}_desc">{{ $item->description }}</span>
                @if (!empty($item->reference_material_url))
                <br/>
                <a href="{{ $item->reference_material_url }}" target="_blank">
                    <i class="zmdi zmdi-square-right mr-5" class="text-primary"></i><span id="spn_exam_{{$item->id}}_url">{{ $item->reference_material_url }} </span>
                </a>
                @endif

                <br/><br/>
                @if ($current_user->lecturer_id!=null)
                <a class="text-info btn-edit-modify-examination-modal" href="#" alt="Edit examination" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                    <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                </a> &nbsp;&nbsp;
                <a class="text-info btn-delete-examination" href="#"  alt="Delete examination" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                    <i class="fa fa-trash" style=""></i>&nbsp;Delete
                </a> &nbsp;&nbsp;

                <a class="text-info btn-assignment-submissions" href="{{ route('submitted-assignment-list', [$item->course_class_id, $item->id]) }}"  alt="Submissions" style="opacity:1;font-size:85%"
                    data-val="{{$item->id}}" > <strong>
                        @php
                            $no = $item->grades()->where('class_material_id', $item->id)             
                                                ->where('course_class_id', $item->course_class_id)->count();
                            if( $no == 0){
                                $submissions = "No scores entered";
                            }elseif($no == 1){
                                $submissions = $no." score has been entered";
                            }else{
                                $submissions = $no." scores has been entered";
                            }
                    @endphp
                        <i class="fa fa-check-square-o" style=""></i>&nbsp;  {{ $submissions }} </strong>
                    </a> &nbsp;&nbsp;

                @endif
            </dd>
        </dl>
        <hr class="light-grey-hr mb-10"/>
    @endif
    
@endforeach
@else
    <p style="font-size:95%;" class="muted">No examinations available.</p>
@endif
