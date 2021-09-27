<div class="table-wrap">
    <div class="table-responsive">
       <table class="table table-bordered">     
            <tr style="background-color: black; color: white">
                <th scope="col">
                    Name
                </th>
                <th>
                    Matric Number
                </th>
                <th scope="col">
                  No. of Downloads
                </th>
                <th scope="col">
                  No. of Reading Material Clicks
                </th>
                <th scope="col">
                  No. of Assignment Clicks
                </th>
                <th scope="col">
                  No. of Lecture Clicks
                </th>

            </tr>
            
        <tbody>
            @foreach ($studentClassActivity as $item)
            <tr>
                <td>
                    {{$item->last_name}} {{$item->first_name}}
                </td>
                <td>
                    {{$item->matriculation_number}}
                </td>
                <td>
                    {{$item->noOfDownloads}}
                </td>
                <td>
                    {{$item->readingMaterialClick}}
                </td>
                <td>
                    {{$item->lectureMaterialClick}}
                </td>
                <td>
                    {{$item->assignmentMaterialClick}}
                </td>
            <tr>
            @endforeach
            
        </tbody>
       </table>
       
        
    </div>
</div>
{{ $studentClassActivity->onEachSide(20)->links() }}