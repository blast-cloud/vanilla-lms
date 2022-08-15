    @if ($current_user->lecturer_id!=null && optional($current_semester)->id == $courseClass->semester_id)
    <a id="btn-show-start-lecture-modal" href="#" class="btn btn-xs btn-primary">
        <i class="fa fa-camera" style=""></i> Create Lecture
    </a>
    <br/>
    @endif

    <hr class="light-grey-hr mb-10 mt-0"/>
    @php
         $current_time = $timeObj->now( $_COOKIE['myTimezone']);    
    @endphp
    @php
        $lecture_classes = $classActivities->get_class_lectures();  
    @endphp

    @if ($lecture_classes!=null && count($lecture_classes)>0)
    @foreach($lecture_classes as $item)
        @if ($item->course_class_id == $courseClass->id )
            <dl>
                <dt class="ma-10">
                    Lecture #<span id="spn_ol_{{$item->id}}_num">{{$item->lecture_number}}</span> - <span id="spn_ol_{{$item->id}}_title">{{$item->title}}</span>


                    @if ($item->blackboard_meeting_status=="in-progress")
                        @if ($current_user->manager_id == null && $current_user->lecturer_id == null && optional($current_semester)->id == $courseClass->semester_id)
                        <span class="pull-right">
                        <a href="{{ route('dashboard.class.join-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary {{ auth()->user()->lecturer_id == null ? 'join-lecture-btn':'' }}" data-save-details="{{ route('dashboard.class.save-details', [$courseClass->id,$item->id]) }}">
                            <i class="fa fa-sign-in" style=""></i>&nbsp;Join Lecture
                        </a>
                        @endif
                        </span>
                        <span class="pull-right">
                        @if ($current_user->lecturer_id!=null && optional($current_semester)->id == $courseClass->semester_id)
                        <a href="{{ route('dashboard.class.end-lecture',[$courseClass->id,$item->id]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-stop-circle" style=""></i>&nbsp;End Lecture
                        </a>
                        @endif
                        </span>
                        
                    @else
                        @if ($current_user->lecturer_id!=null && $item->blackboard_meeting_status=="new" && optional($current_semester)->id == $courseClass->semester_id)
                        <a href="{{ route('dashboard.class.start-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary pull-right">
                            <i class="fa fa-play" style=""></i>&nbsp;Start Lecture
                        </a>
                        @endif
                    @endif
                    @if($current_user->lecturer_id != null && $item->blackboard_meeting_status=="ended")
                        <a href="{{ route('dashboard.class.record-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary pull-right">
                            <i class="fa fa-play" style=""></i>&nbsp;Play Recording
                        </a>
                    @endif
                    @if($current_user->student_id != null && $item->blackboard_meeting_status=="ended")
                        <a href="{{ route('dashboard.class.record-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary pull-right">
                            <i class="fa fa-play" style=""></i>&nbsp;Play Recording
                        </a>
                    @endif
                    <span class="text-danger">
                    @php
                         if($item->lecture_date != null && $item->blackboard_meeting_status=="new" ){
                           $lectureDate = $timeObj->parse($item->lecture_date)->format('Y-m-d')." ".$timeObj->parse($item->lecture_time)->format('h:i');
                                $remaining_time = $current_time->diffForHumans($lectureDate);
                                if(strpos($remaining_time,"before")){
                                    echo "- ".$remaining_time. " Lecture starts";
                                }
                            
                            }
                                
                    @endphp
                    </span>
                    <span class="text-primary" style="font-size:90%"><br/>
                    @if ($item->blackboard_meeting_status=="in-progress" && $current_user->manager_id == null && $current_user->lecturer_id == null && optional($current_semester)->id == $courseClass->semester_id)
                        Online class is IN PROGRESS from {{ $item->created_at->format('d-M-Y h:m') }}, click the Join button to join the lecture
                    @elseif ($item->blackboard_meeting_status=="new" && optional($current_semester)->id == $courseClass->semester_id)
                        @if($current_user->lecturer_id != null)
                            Online class is READY to start, click the Start button to commence the Lecture.
                        @else
                            Online class is READY to start, you can click the Start button to Join when the Lecturer starts the Lecture.
                        @endif
                    @elseif ($item->blackboard_meeting_status=="ended") 
                        Online class has ENDED, the lecture recordings will soon be available soon.
                    @elseif ($item->blackboard_meeting_status=="video-available") 
                        Online class has ENDED, the lecture recordings is available for viewing.
                    @elseif ($item->blackboard_meeting_status=="in-progress" && $current_user->lecturer_id != null && optional($current_semester)->id == $courseClass->semester_id)
                        Your class is currently in progress. You may click End lecture button to end the class.
                    @endif
                    <br>
                    </span>
                    @if($item->lecture_date)
                    lecture Date:  <span id="spn_ol_{{$item->id}}_lecture_date">@php echo $timeObj->parse($item->lecture_date)->format('Y-m-d'); @endphp</span> <span id="spn_ol_{{$item->id}}_lecture_time">@php echo $timeObj->parse($item->lecture_time)->format('h:i A');@endphp</span>
                    </span>
                    @endif
                    

                </dt>
                <dd class="ma-10" style="font-size:90%;">
                    <span id="spn_ol_{{$item->id}}_desc">{{ $item->description }} </span>
                    @if (!empty($item->reference_material_url))
                    <br/>
                    @if($current_user->student_id != null)
                    <a href="{{ $item->reference_material_url }}" target="_blank" style="font-size:85%" class="btn-student-class-activity" student-id="{{$current_user->student_id}}" course-class-id="{{$item->course_class_id}}" class-material-id = "{{$item->id}}" user-click = "1" downloaded="0">
                        <i class="zmdi zmdi-square-right mr-5" class="text-primary" style="color:blue"></i>{{ $item->reference_material_url }}
                    </a>
                    @else
                    <a href="{{ $item->reference_material_url }}" target="_blank" style="font-size:85%">
                        <i class="zmdi zmdi-square-right mr-5" class="text-primary" style="color:blue"></i><span id="spn_ass_{{$item->id}}_url" class="text-primary">{{ $item->reference_material_url }} </span>
                    </a>
                    @endif
                    @endif

                    @if (!empty($item->upload_file_path))
                    <br/>
                    @if($current_user->student_id != null)
                    <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%" class="text-primary btn-student-class-activity" target="_blank" download student-id="{{$current_user->student_id}}" course-class-id="{{$item->course_class_id}}" class-material-id = "{{$item->id}}" user-click = "0" downloaded="1">
                        <i class="fa fa-download mr-5" class="text-primary"></i>Download
                    </a>
                    @else
                    <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%" class="text-primary" target="_blank" download >
                        <i class="fa fa-download mr-5" class="text-primary"></i>Download
                    </a>
                    @endif
                    @endif
                    
                    <br/> <br/>
                       
                    @if ($current_user->lecturer_id!=nulL)
                        
                        @if (optional($current_semester)->id == $courseClass->semester_id)
                        <a class="text-info btn-edit-start-lecture-modal" href="#" alt="Edit Lecture" style="font-size:85%;opacity:0.5;" data-val="{{$item->id}}">
                            <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                        </a> &nbsp;&nbsp;
                        <a class="text-info btn-delete-lecture" href="#"  alt="Delete Lecture" style="font-size:85%;opacity:0.5;" data-val="{{$item->id}}">
                            <i class="fa fa-trash" style=""></i>&nbsp;Delete
                        </a> &nbsp;&nbsp;
                        @endif
                        <a class="text-info btn-lecture-attendance" href="#"  alt="Lecture Attendance" style="font-size:85%;opacity:0.5;" data-toggle="modal" data-target="#attendance_{{ $item->id }}">
                            <i class="fa fa-users" style=""></i>&nbsp;Attendance {{$item->attendance->count()}}
                        </a>
                    @endif
                </dd>
            </dl>
            <hr class="light-grey-hr mb-10"/>
        @endif
        
    @endforeach
    @else
        <p style="font-size:95%;" class="muted">No Lectures available.</p>
    @endif
@include('dashboard.class.modals.lecture-start')
@include('dashboard.class.modals.student-capture')
@include('dashboard.class.modals.lecture-attendance')
@section('js-131')
    <script type="text/javascript">
        $(document).ready(function() {
            
            
            $('.btn-student-class-activity').click(function(e) {
              
              e.preventDefault();
              let materialUrl = e.target.href;
               if ({{optional($current_semester)->id == $courseClass->semester_id}}) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                let url = "{{route('studentClassActivity.store')}}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('clicked',e.target.attributes['user-click'].value);
                formData.append('downloaded',e.target.attributes['downloaded'].value)
                formData.append('course_class_id',e.target.attributes['course-class-id'].value);
                formData.append('student_id',e.target.attributes['student-id'].value);
                formData.append('class_material_id',e.target.attributes['class-material-id'].value);
               
             
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result){
                       window.open(materialUrl,'_blank');
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
               }else{
                    window.open(materialUrl,'_blank');  
               }
                
                
            });

        })
    </script>
 @endsection