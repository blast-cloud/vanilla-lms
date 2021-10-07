<div class="col-sm-12 panel panel-default card-view pa-10">
   
        <table class="table table-bordered table-hover table-responsive table-condensed">     
            <thead>
                <tr>
                    <th scope="col" class=" text-center">
                        S/N
                    </th>
                    <th scope="col" class=" text-center">
                        Name
                    </th>
                    <th scope="col" class="text-center">
                    Lecture Views
                    </th>
                    <th scope="col"  class="text-center">
                    Assignment Views
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrolledStudentClassActivity as $key => $item)
                <tr class="text-center">
                    <td>
                        {{$key + 1}}
                    </td>
                    <td>
                        {{$item['first_name']}}  {{$item['last_name']}}
                        {{-- <br> --}}
                            - {{$item['matriculation_number']}}
                    </td>
                    <td>
                        @if($item['assignmentClick'] == null)
                            0
                        @else
                        {{$item['assignmentClick']}}
                        @endif
                    </td>
                    <td>
                        
                        @if($item['lectureMaterialClick'] == null)
                            0
                        @else
                        {{$item['lectureMaterialClick']}}
                        @endif
                    </td>
                <tr>
                @endforeach
                
            </tbody>
        </table>

</div>
