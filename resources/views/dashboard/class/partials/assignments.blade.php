    @if ($current_user->lecturer_id!=null)
    <a href="#" id="btn-show-modify-assignment-modal" class="btn btn-xs btn-primary">
        <i class="fa fa-upload" style=""></i> Add New Assignment
    </a>
    <br/>
    @endif

    <hr class="light-grey-hr mb-10 mt-0"/>

    @if ($class_assignments!=null && count($class_assignments)>0)
    @foreach($class_assignments as $item)
        <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt class="mb-0">
                            Assignment #<span id="spn_ass_{{$item->id}}_num">{{$item->assignment_number}}</span> - Due on <span id="spn_ass_{{$item->id}}_date">{{ date('Y-m-d', strtotime($item->due_date)) }} </span> - <span id="spn_ass_{{$item->id}}_title">{{$item->title}}</span>
                            <span class="text-danger" style="font-size:80%"><br/>
                            Posted on {{ $item->created_at->format('d-M-Y') }} &nbsp;&nbsp;|&nbsp;&nbsp;  Points <span id="spn_ass_{{$item->id}}_max_points">{{ $item->grade_max_points }}</span>, contributes <span id="spn_ass_{{$item->id}}_contrib">{{ $item->grade_contribution_pct }}</span>% to final score.
                            </span> <br>
                        </dt>
                        <dd class="mb-0" style="font-size:85%;">
                            <span id="spn_ass_{{$item->id}}_desc">{{ $item->description }}</span>
                            @if (!empty($item->reference_material_url))
                            <br/>
                            <a href="{{ $item->reference_material_url }}" target="_blank">
                                <i class="zmdi zmdi-square-right mr-5" class="text-primary"></i><span id="spn_ass_{{$item->id}}_url">{{ $item->reference_material_url }} </span>
                            </a>
                            @endif
                            @if (!empty($item->upload_file_path))
                            <br/>
                            <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%" class="text-primary" target="_blank" download >
                                <i class="fa fa-download mr-5" class="text-primary"></i>Download
                            </a>
                            @endif
            
                            <br/><br/>
                            @if ($current_user->lecturer_id!=null)
                            <a class="text-info btn-edit-modify-assignment-modal" href="#" alt="Edit Assignment" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                                <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                            </a> &nbsp;&nbsp;
                            <a class="text-info btn-delete-assignment" href="#"  alt="Delete Assignment" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                                <i class="fa fa-trash" style=""></i>&nbsp;Delete
                            </a> &nbsp;&nbsp;
                            <a class="text-info btn-assignment-submissions" href="{{ route('submitted-assignment-list', [$item->course_class_id, $item->id]) }}"  alt="Submissions" style="opacity:1;font-size:85%"
                             data-val="{{$item->id}}" > <strong>
                                @php
                                    $no = $item->submissions()->where('class_material_id', $item->id)
                                                                        ->where('grade_id', null)
                                                                    ->where('course_class_id', $item->course_class_id)->count();
                                    if( $no == 0){
                                        $submissions = "No Submissions Yet";
                                    }elseif($no == 1){
                                        $submissions = $no." Person has Submitted,  yet to be Graded";
                                    }else{
                                        $submissions = $no." Persons has Submitted, yet to be Graded";
                                    } 
                            @endphp
                                <i class="fa fa-check-square-o" style=""></i>&nbsp;  {{ $submissions }} </strong>
                            </a> &nbsp;&nbsp;
                            {{-- <a class="text-info btn-assignment-grades" href="#"  alt="Grades" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                                <i class="fa fa-bar-chart-o" style=""></i>&nbsp;Grades
                            </a> --}}
                            @endif
            
                        </dd>
                    </dl>
                    
                </div>

                <div class="col-md-2">

                    @php
                            $submission = $item->submissions()->where('student_id', $current_user->student_id)
                                    ->where('class_material_id', $item->id)
                                    ->where('course_class_id', $item->course_class_id)->first();
                            $assignment_graded = $item->submissions()->where('student_id', $current_user->student_id)
                                    ->where('class_material_id', $item->id)
                                    ->where('grade_id','<>', null)
                                    ->where('course_class_id', $item->course_class_id)->pluck('grade_id')->first();
                            $assignment_due_date =  strtotime($item->due_date) - time();
                    @endphp

                    @if (($current_user->student_id) && $assignment_graded !=null )

                         {{ $submission->grade->score  }} / {{ $item->grade_max_points }} 
                        
                        
                    @endif
                   
                </div>


                <div class="col-md-2">
                    
                    @if (($current_user->student_id) && $submission !=null)

                        <a href="{{ asset($submission->upload_file_path) }}"  class="btn btn-xs btn-info"
                        data-val="{{$item->id}}" download>
                            <i class="fa fa-download" style=""></i> View 
                        </a>
                        <br/>
                    @endif
                    <br/>
                   
                </div>
                <div class="col-md-2">

                    @if (($current_user->student_id!=null) && ($assignment_graded ==null)  && (($item->allow_late_submission == false &&  $assignment_due_date > 0) || $item->allow_late_submission == true  )  )
                    <button href="#" id="btn-show-submit-assignment-modal" class="btn btn-xs btn-primary btn-show-submit-assignment-modal"
                     data-val="{{$item->id}}" data-val-course-class-id="{{$item->course_class_id}}" data-val-student-id="{{$current_user->student_id}}" data-val-assignment-title="{{$item->title}}"
                     data-val-submission-id="{{ ($submission) ? $submission->id : '0' }}" >
                        <i class="fa fa-upload" style=""></i> Submit 
                    </button>
                    <br/>
                @endif

                        
                </div>

                <hr class="col-md-12 light-grey-hr mb-10"/>
        </div>
        
    @endforeach
    @else
        <p style="font-size:95%;" class="muted">No Assignments available.</p>
    @endif
