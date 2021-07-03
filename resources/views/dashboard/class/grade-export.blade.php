
@if (count($enrollments)>0)
    <table>
        <thead>
            <tr>
                <td>Student</td>
                
                <td>Final Grade</td>

                @foreach($gradeManager->get_assignment_list() as $idx=>$item)
                    @if ($item->course_class_id == $courseClass->id )
                        <td>
                            Assignment {{ $item->assignment_number }} <!-- - {{ $item->title }} --> <br/>
                            <span>{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span>
                        </td>   
                    @endif
                @endforeach

                @foreach($gradeManager->get_examination_list() as $idx=>$item)
                    @if ($item->course_class_id == $courseClass->id )
                        <td>
                            Exam {{ $item->examination_number }} <!-- - {{ $item->title }} --> <br/>
                            <span>{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span>
                        </td>
                    @endif
                @endforeach
            </tr>
        </thead>
        @foreach($gradeManager->get_map() as $idx=>$grade_item)
        <tr>

            <td>{{$grade_item['name']}} - {{$grade_item['matric_num']}}</td>

            <td>{{ isset($grade_item['final-grade']) ? $grade_item['final-grade']['score'] : 0 }}</td>

            @foreach($gradeManager->get_assignment_list() as $idx=>$item)
                @if ($item->course_class_id == $courseClass->id )
                    <td>{{ $grade_item['assignments'][$idx]['score'] }}</td>
                @endif
            @endforeach

            @foreach($gradeManager->get_examination_list() as $idx=>$item)
                @if ($item->course_class_id == $courseClass->id )
                    <td>{{ $grade_item['examinations'][$idx]['score'] }}</td>
                @endif
            @endforeach

        </tr>
        @endforeach
    </table>
@endif

