@if (count($enrollments)>0)
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>Student</td>
                <td class="text-center" style="font-size:80%">
                    Final Grade
                </td>
                @foreach($gradeManager->get_assignment_list() as $idx=>$item)
                <td class="text-center" style="font-size:80%">
                    Assignment {{ $item->assignment_number }} <br/>
                    <span class="text-info">{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span>
                </td>
                @endforeach
                @foreach($gradeManager->get_examination_list() as $idx=>$item)
                <td class="text-center" style="font-size:80%">
                    Exam {{ $item->examnation_number }} - {{ $item->title }}<br/>
                    <span class="text-info">{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span>
                </td>
                @endforeach
            </tr>
        </thead>
        @foreach($gradeManager->get_map() as $idx=>$grade_item)
        <tr>
            <td>{{$grade_item['name']}} - {{$grade_item['matric_num']}}</td>
            <td>
                {!! Form::number("txt_score_{$idx}", null, ['id'=>"txt_score_{$idx}", 'placeholder'=>"",'class' => 'form-control']) !!}
            </td>

            @foreach($gradeManager->get_assignment_list() as $idx=>$item)
            <td>
                @php
                $grade_item['assignments'][$idx]
                @endphp
                {!! Form::number("txt_{$idx}", null, ['id'=>"txt_{$idx}", 'placeholder'=>"",'class' => 'form-control']) !!}
            </td>
            @endforeach

            @foreach($gradeManager->get_examination_list() as $idx=>$item)
            <td>
                @php
                $grade_item['examinations'][$idx]
                @endphp
                {!! Form::number("txt_{$idx}", null, ['id'=>"txt_{$idx}", 'placeholder'=>"",'class' => 'form-control']) !!}
            </td>
            @endforeach
        </tr>
        @endforeach
    </table>
@else
No Enrolled Students
@endif