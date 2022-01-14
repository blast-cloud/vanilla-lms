<div class="col-sm-12 panel panel-default card-view pa-20">
    @php
        $enrolledStudentClassActivity  = $classActivities->get_map();
    @endphp
   
        <table class="table table-bordered table-hover table-responsive table-condensed">     
            <thead>
                <tr>
                    <th scope="col-sm-3" class="text-left">
                        Student
                    </th>
                    <th  scope="col-sm-3" class="text-center">
                        Participation
                    </th>
                    <th scope="col" class="text-center" style="font-size:80%">
                        Lectures <br/>
                        <span class="text-info small">(# of Views)</span>
                    </th>
                    <th scope="col"  class="text-center" style="font-size:80%">
                        Assignments <br/>
                        <span class="text-info small">(# of Views)</span>
                    </th>
                    <th scope="col"  class="text-center" style="font-size:80%">
                        Reading Materials <br/>
                        <span class="text-info small">(# of Views)</span>
                    </th>
                    <th scope="col"  class="text-center" style="font-size:80%">
                        Discussions <br/>
                        <span class="text-info small">(# of Posts)</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($enrolledStudentClassActivity != null && count($enrolledStudentClassActivity)>0)
                @foreach ($enrolledStudentClassActivity as $key => $item)
                <tr class="text-left">
                    @php
                        $score = $classActivities->get_activity_score($courseClass->id, $item['student_id']);
                        $score_color = "text-danger";
                        if ($score !=null && strtolower($score)=="high"){
                            $score_color = "text-primary";
                        }
                    @endphp
                    <td class="participation_score" data-participation-score="{{ucwords($score)}}" data-participation-matric="{{$item['matriculation_number']}}" data-student-id ="{{$item['student_id']}}">
                        {{$item['first_name']}}  {{$item['last_name']}} - {{$item['matriculation_number']}}
                    </td>
                    <td class="text-center">
                        @if ($score == null)
                            <span class="small text-danger">No Activity</span>
                        @else
                            <h4 class="{{$score_color}} small" style="font-weight:900;">{{ strtoupper($score) }}</h4>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['lectureMaterialClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-primary small">
                                {{ number_format($item['lectureMaterialClick']) }} view(s) <br/>
                                @php
                                     $lecture_classes = $classActivities->get_class_lectures();
                                @endphp
                                <span class="small text-danger">out of {{ count(($lecture_classes)) }} lectures</span>
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        
                        @if($item['assignmentClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-primary small">
                                {{ number_format($item['assignmentClick']) }} view(s) <br/>
                                @php
                                     $class_assignments = $classActivities->get_class_assignment(); 
                                @endphp
                                <span class="small text-danger">out of {{ count($class_assignments) }} assignment(s)</span>
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                    @if($item['readingMaterialClick'] == null)
                        <span class="text-danger small">No Activity</span>
                    @else
                        <span class="text-primary small">
                            {{ number_format($item['readingMaterialClick']) }} view(s) <br/>
                                @php
                                    $reading_materials = $classActivities->get_reading_materials()
                                @endphp 
                            <span class="small text-danger">out of {{ count($reading_materials) }} reading materials</span>
                        </span>
                    @endif
                    </td>
                    <td class="text-center">
                        @if($item['discussion'] == null)
                        <span class="text-danger small">No Activity</span>
                    @else
                        <span class="text-primary small">
                            {{ number_format($item['discussion']) }}<br/>
                            <span class="text-danger"> post(s)</span>
                        </span>
                    @endif
                    </td>
                <tr>
                @endforeach
                @else
                <tr class="text-left">
                    <td class="text-center" colspan="5">
                        No students enrolled.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

</div>
