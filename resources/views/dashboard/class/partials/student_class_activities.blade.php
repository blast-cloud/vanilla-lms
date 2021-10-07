<div class="col-sm-12 panel panel-default card-view pa-20">
   
        <table class="table table-bordered table-hover table-responsive table-condensed">     
            <thead>
                <tr>
                    <th scope="col-sm-3" class="text-left">
                        Student
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
                    <td>
                        {{$item['first_name']}}  {{$item['last_name']}} - {{$item['matriculation_number']}}
                    </td>
                    <td class="text-center">
                        @if($item['assignmentClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-info small">{{ number_format($item['assignmentClick']) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        
                        @if($item['lectureMaterialClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-info small">{{ number_format($item['lectureMaterialClick']) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{-- //TODO: Get the number of times this number has viewed the reading materials --}}
                        <span class="text-danger small">No Activity</span>
                    </td>
                    <td class="text-center">
                        {{-- //TODO: Get the number of posts this student has made in the discussion forum for this class --}}
                        <span class="text-danger small">No Activity</span>
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
