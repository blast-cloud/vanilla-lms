    @if ($current_user->lecturer_id!=null)
    <a href="#" id="btn-show-modify-assignment-modal" class="btn btn-xs btn-primary">
        <i class="fa fa-upload" style=""></i> Add New Assignment
    </a>
    @endif

    <br/>
    <hr class="light-grey-hr mb-10"/>

    @if ($class_assignments!=null && count($class_assignments)>0)
    @foreach($class_assignments as $item)
        <dl>
            <dt class="mb-0">
                Assignment #<span id="spn_ass_{{$item->id}}_num">{{$item->assignment_number}}</span> - Due on <span id="spn_ass_{{$item->id}}_date">{{ date('Y-m-d', strtotime($item->due_date)) }} </span> - <span id="spn_ass_{{$item->id}}_title">{{$item->title}}</span>
                <span class="text-danger" style="font-size:80%"><br/>
                Posted on {{ $item->created_at->format('d-M-Y') }}
                </span>
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
                <a class="text-info btn-assignment-submissions" href="#"  alt="Submissions" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                    <i class="fa fa-check-square-o" style=""></i>&nbsp;Submissions
                </a> &nbsp;&nbsp;
                <a class="text-info btn-assignment-grades" href="#"  alt="Grades" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                    <i class="fa fa-bar-chart-o" style=""></i>&nbsp;Grades
                </a>
                @endif
            </dd>
        </dl>
        <hr class="light-grey-hr mb-10"/>
    @endforeach
    @else
        <p style="font-size:95%;" class="muted">No Assignments available.</p>
    @endif
