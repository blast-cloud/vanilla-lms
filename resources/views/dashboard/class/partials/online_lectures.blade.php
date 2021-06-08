    @if ($current_user->lecturer_id!=null)
    <a id="btn-show-start-lecture-modal" href="#" class="btn btn-xs btn-primary">
        <i class="fa fa-camera" style=""></i> Create Lecture
    </a>
    <br/>
    @endif

    <hr class="light-grey-hr mb-10 mt-0"/>

    @if ($lecture_classes!=null && count($lecture_classes)>0)
    @foreach($lecture_classes as $item)
        @if ($item->course_class_id == $courseClass->id )
            <dl>
                <dt class="ma-10">
                    Lecture #<span id="spn_ol_{{$item->id}}_num">{{$item->lecture_number}}</span> - <span id="spn_ol_{{$item->id}}_title">{{$item->title}}</span>


                    @if ($item->blackboard_meeting_status=="in-progress")
                        <div class="pull-right">
                        <a href="{{ route('dashboard.class.join-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary">
                            <i class="fa fa-sign-in" style=""></i>&nbsp;Join Lecture
                        </a>
                        @if ($current_user->lecturer_id!=null)
                        <a href="{{ route('dashboard.class.end-lecture',[$courseClass->id,$item->id]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-stop-circle" style=""></i>&nbsp;End Lecture
                        </a>
                        @endif
                        </div>
                    @else
                        @if ($current_user->lecturer_id!=null && $item->blackboard_meeting_status=="new")
                        <a href="{{ route('dashboard.class.start-lecture',[$courseClass->id,$item->id]) }}" target="_blank" class="btn btn-xs btn-primary pull-right">
                            <i class="fa fa-play" style=""></i>&nbsp;Start Lecture
                        </a>
                        @endif
                    @endif

                    <span class="text-primary" style="font-size:90%"><br/>
                    @if ($item->blackboard_meeting_status=="in-progress")
                        Online class is IN PROGRESS from {{ $item->created_at->format('d-M-Y h:m') }}, click the Join button to join the lecture
                    @elseif ($item->blackboard_meeting_status=="new")
                        Online class is READY to start, click the Start button to commence the Lecture
                    @elseif ($item->blackboard_meeting_status=="ended") 
                        Online class has ENDED, the lecture recordings will soon be available soon.
                    @elseif ($item->blackboard_meeting_status=="video-available") 
                        Online class has ENDED, the lecture recordings is available for viewing.
                    @endif
                    </span>

                </dt>
                <dd class="ma-10" style="font-size:90%;">
                    <span id="spn_ol_{{$item->id}}_desc">{{ $item->description }} </span>
                    @if (!empty($item->reference_material_url))
                    <br/>
                    <a href="{{ $item->reference_material_url }}" target="_blank" style="font-size:85%">
                        <i class="zmdi zmdi-square-right mr-5" class="text-primary" style="color:blue"></i><span id="spn_ass_{{$item->id}}_url" class="text-primary">{{ $item->reference_material_url }} </span>
                    </a>
                    @endif

                    @if (!empty($item->upload_file_path))
                    <br/>
                    <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%" class="text-primary" target="_blank" download >
                        <i class="fa fa-download mr-5" class="text-primary"></i>Download
                    </a>
                    @endif
                    
                    <br/> <br/>
                    @if ($current_user->lecturer_id!=null)
                        <a class="text-info btn-edit-start-lecture-modal" href="#" alt="Edit Lecture" style="font-size:85%;opacity:0.5;" data-val="{{$item->id}}">
                            <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                        </a> &nbsp;&nbsp;
                        <a class="text-info btn-delete-lecture" href="#"  alt="Delete Lecture" style="font-size:85%;opacity:0.5;" data-val="{{$item->id}}">
                            <i class="fa fa-trash" style=""></i>&nbsp;Delete
                        </a> &nbsp;&nbsp;
                        <a class="text-info btn-lecture-attendance" href="#"  alt="Lecture Attendance" style="font-size:85%;opacity:0.5;" data-val="{{$item->id}}">
                            <i class="fa fa-users" style=""></i>&nbsp;Attendance
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