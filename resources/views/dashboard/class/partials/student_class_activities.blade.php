<div class="col-sm-12 panel panel-default card-view pa-20">
   
        <table class="table table-bordered table-hover table-responsive table-condensed">     
            <thead>
                <tr>
                    <th scope="col-sm-3" class=" text-left">
                        Name
                    </th>
                    <th scope="col" class="text-center">
                    Lecture Views
                    </th>
                    <th scope="col"  class="text-center">
                    Assignment Views
                    </th>
                    <th scope="col"  class="text-center">
                        Reading Material Views
                    </th>
                    <th scope="col"  class="text-center">
                        Discussions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrolledStudentClassActivity as $key => $item)
                <tr class="text-left">
                    <td>
                        {{$item['first_name']}}  {{$item['last_name']}} - {{$item['matriculation_number']}}
                    </td>
                    <td class="text-center">
                        @if($item['assignmentClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-success small">{{$item['assignmentClick']}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        
                        @if($item['lectureMaterialClick'] == null)
                            <span class="text-danger small">No Activity</span>
                        @else
                            <span class="text-success small">{{$item['lectureMaterialClick']}}</span>
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
            </tbody>
        </table>

</div>
