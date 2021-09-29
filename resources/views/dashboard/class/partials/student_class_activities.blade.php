<div class="table-wrap">
   
    <div class="table-responsive">
       <table class="table table-condensed analytic-table">     
            <tr class="analytic-table-color">
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
            @foreach ($studentClassActivity as $item)
            <tr class="text-center">
                <td>
                    {{$item->last_name}} {{$item->first_name}}
                    <br>
                    {{$item->matriculation_number}}
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