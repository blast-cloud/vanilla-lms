    @if ($current_user->lecturer_id != null && optional($current_semester)->id == $courseClass->semester_id)
        <a href="#" id="btn-show-modify-assignment-modal" class="btn btn-xs btn-primary">
            <i class="fa fa-upload" style=""></i> Add New Assignment
        </a>
        <br />
    @endif
    @php
        $class_assignments = $classActivities->get_class_assignment();
    @endphp
    <hr class="light-grey-hr mb-10 mt-0" style="width:96%" />

    @if ($class_assignments != null && count($class_assignments) > 0)
        @foreach ($class_assignments as $item)
            <div class="row">
                @if ($item->course_class_id == $courseClass->id)
                    <div class="col-md-6">
                        <dl>
                            <dt class="mb-0">
                                Assignment #<span id="spn_ass_{{ $item->id }}_num">{{ $item->assignment_number }}</span> - Due on
                                <span id="spn_ass_{{ $item->id }}_date">{{ date('Y-m-d', strtotime($item->due_date)) }} </span> at 
                                 <span id="spn_ass_{{$item->id}}_time">@php echo $timeObj->parse($item->due_time)->format('h:i A');@endphp</span> - 
                                 <span id="spn_ass_{{ $item->id }}_title">{{ $item->title }}</span>
                                <span class="text-danger" style="font-size:80%"><br />
                                    Posted on {{ $item->created_at->format('d-M-Y') }} &nbsp;&nbsp;|&nbsp;&nbsp; Points
                                    <span
                                        id="spn_ass_{{ $item->id }}_max_points">{{ $item->grade_max_points }}</span>,
                                    contributes <span
                                        id="spn_ass_{{ $item->id }}_contrib">{{ $item->grade_contribution_pct }}</span>%
                                    to final score.
                                </span> <br>
                            </dt>
                            <dd class="mb-0" style="font-size:85%;">
                                <span id="spn_ass_{{ $item->id }}_desc">{{ $item->description }} </span>
                                @if (!empty($item->reference_material_url))
                                    <br />
                                    @if ($current_user->student_id != null)
                                        <a href="{{ $item->reference_material_url }}" target="_blank"
                                            class="btn-student-class-activity"
                                            student-id="{{ $current_user->student_id }}"
                                            course-class-id="{{ $item->course_class_id }}"
                                            class-material-id="{{ $item->id }}" user-click="1" downloaded="0">
                                            <i class="zmdi zmdi-square-right mr-5"
                                                class="text-primary"></i>{{ $item->reference_material_url }}
                                        </a>
                                    @else
                                        <a href="{{ $item->reference_material_url }}" target="_blank">
                                            <i class="zmdi zmdi-square-right mr-5" class="text-primary"></i><span
                                                id="spn_ass_{{ $item->id }}_url">{{ $item->reference_material_url }}
                                            </span>
                                        </a>
                                    @endif
                                @endif
                                @if (!empty($item->upload_file_path))
                                    <br />
                                    @if ($current_user->student_id != null)
                                        <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%"
                                            class="text-primary btn-student-class-activity" target="_blank" download
                                            student-id="{{ $current_user->student_id }}"
                                            course-class-id="{{ $item->course_class_id }}"
                                            class-material-id="{{ $item->id }}" user-click="0" downloaded="1">
                                            <i class="fa fa-download mr-5" class="text-primary"></i>Download
                                        </a>
                                    @else
                                        <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%"
                                            class="text-primary" target="_blank" download>
                                            <i class="fa fa-download mr-5" class="text-primary"></i>Download
                                        </a>
                                    @endif
                                @endif

                                <br /><br />
                                @if ($current_user->lecturer_id != null)
                                    @if (optional($current_semester)->id == $courseClass->semester_id)
                                        <a class="text-info btn-edit-modify-assignment-modal" href="#"
                                            alt="Edit Assignment" style="opacity:0.5;font-size:85%"
                                            data-val="{{ $item->id }}"
                                            allow-late-submission={{ $item->allow_late_submission }}>
                                            <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                                        </a> &nbsp;&nbsp;
                                        <a class="text-info btn-delete-assignment" href="#"
                                            alt="Delete Assignment" style="opacity:0.5;font-size:85%"
                                            data-val="{{ $item->id }}">
                                            <i class="fa fa-trash" style=""></i>&nbsp;Delete
                                        </a> &nbsp;&nbsp;
                                    @endif
                                    <a class="text-info btn-assignment-submissions"
                                        href="{{ route('submitted-assignment-list', [$item->course_class_id, $item->id]) }}"
                                        alt="Submissions" style="opacity:1;font-size:85%"
                                        data-val="{{ $item->id }}"> <strong>
                                            @php
                                                $no = $item
                                                    ->submissions()
                                                    ->where('class_material_id', $item->id)
                                                    ->where('course_class_id', $item->course_class_id)
                                                    ->count();
                                                if ($no == 0) {
                                                    $submissions = 'No submission from students';
                                                } elseif ($no == 1) {
                                                    $submissions = $no . ' student has submitted';
                                                } else {
                                                    $submissions = $no . ' students has submitted';
                                                }
                                            @endphp
                                            <i class="fa fa-check-square-o" style=""></i>&nbsp;
                                            {{ $submissions }} </strong>
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
                            $submission = $item
                                ->submissions()
                                ->where('student_id', $current_user->student_id)
                                ->where('class_material_id', $item->id)
                                ->where('course_class_id', $item->course_class_id)
                                ->first();
                            $is_assignment_graded = $submission && $submission->grade_id != null ? true : false;
                           //$assignment_due_date = strtotime($item->due_date . ' +1 day') - time();
                            //$assignment_due_time = strtotime($item->due_time) - time();
                        @endphp
                        <div class="col-md-12">
                            @if ($current_user->student_id && $is_assignment_graded == true)
                                <strong> Score: </strong> {{ $submission->grade->score }} /
                                {{ $item->grade_max_points }}
                            @endif
                        </div>
                        <div class="col-md-12">
                            @if ($current_user->student_id && !empty($submission) && $submission->comment != null)
                                <a href="#" class="text-center btn-assignment-remark-modal" style="width: 120px;"
                                    data-val="{{ $submission->id }}">
                                    <i class="fa fa-eye"></i> comment
                                </a>
                            @endif
                        </div>

                    </div>


                    <div class="col-md-2">

                        @if ($current_user->student_id && $submission != null)
                            <a href="{{ asset($submission->upload_file_path) }}" class="btn btn-xs btn-info"
                                data-val="{{ $item->id }}" download>
                                <i class="fa fa-download" style=""></i> View
                            </a>
                            <br />
                        @endif
                        <br />

                    </div>
                    <div class="col-md-2">
                        @php
                        $hours = "";
                        $minutes = "";
                        $time= "";
                        $due_time_arr = explode(" ", $item->due_time);
                        if(count($due_time_arr) >= 2){
                            $time = explode(":",$due_time_arr[1]);
                            if(count($time)>=3){
                                $hours = $time[0];
                                $minutes = $time[1];
                            }
                        }
                        @endphp

                        @if ($current_user->student_id != null &&
                            !$is_assignment_graded &&
                            (($item->allow_late_submission == false && time() <= strtotime($item->due_date) + ($hours*60*60) + ($minutes*60)) || $item->allow_late_submission == true))
                            @if (optional($current_semester)->id == $courseClass->semester_id)
                                <button href="#" id="btn-show-submit-assignment-modal"
                                    class="btn btn-xs btn-primary btn-show-submit-assignment-modal"
                                    data-val="{{ $item->id }}"
                                    data-val-course-class-id="{{ $item->course_class_id }}"
                                    data-val-student-id="{{ $current_user->student_id }}"
                                    data-val-assignment-title="{{ $item->title }}"
                                    data-val-submission-id="{{ $submission ? $submission->id : '0' }}">
                                    <i class="fa fa-upload" style=""></i> Submit
                                </button>
                                <br />
                            @endif
                        @endif

                    </div>

                    <hr class="col-md-12 light-grey-hr mb-10"  style="width:96%"/>
                @endif

            </div>
        @endforeach
    @else
        <p style="font-size:95%;" class="muted">No Assignments available.</p>
    @endif
    @section('js-131')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.btn-student-class-activity').click(function(e) {

                    e.preventDefault();
                    let materialUrl = e.target.href;
                    if ({{ optional($current_semester)->id == $courseClass->semester_id }}) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            }
                        });
                        let url = "{{ route('studentClassActivity.store') }}";
                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('clicked', e.target.attributes['user-click'].value);
                        formData.append('downloaded', e.target.attributes['downloaded'].value)
                        formData.append('course_class_id', e.target.attributes['course-class-id'].value);
                        formData.append('student_id', e.target.attributes['student-id'].value);
                        formData.append('class_material_id', e.target.attributes['class-material-id'].value);
                      
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(result) {
                                window.open(materialUrl, '_blank');
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    } else {
                        window.open(materialUrl, '_blank');
                    }

                });

            })
        </script>
    @endsection
