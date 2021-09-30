<div class="table-wrap">
   
    <div class="table-responsive">
       <table class="table table-condensed analytic-table">     
            <tr class="analytic-table-color">
                <th scope="col" class=" text-center">
                    S/N
                </th>
                <th scope="col" class=" text-center">
                    Name
                </th>
                <th scope="col" class="text-center">
                  Lecture Clicks
                </th>
                <th scope="col"  class="text-center">
                  Assignment Clicks
                </th>

            </tr>
            
        <tbody>
            @foreach ($enrolledStudentClassActivity as $key => $item)
            <tr class="text-center">
                <td>
                    {{$key + 1}}
                </td>
                <td>
                    {{$item['first_name']}}  {{$item['last_name']}}
                    <br>
                        {{$item['matriculation_number']}}
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
</div>
