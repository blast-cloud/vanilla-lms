
    <div class="panel panel-default card-view">
        <div class="panel-heading" style="padding: 10px 15px;">
            <div class="pull-left">
                <h4 class="panel-title txt-dark">Course Catalog</h4>
            </div>
            <div class="pull-right">
                <!-- <a href="{{ route('dashboard.class',0) }}" class="pull-left inline-block mr-15">
                    <i class="zmdi zmdi-surround-sound" style="font-size:inherit;"></i>
                </a> -->
                <div class="pull-left inline-block dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                        <li role="presentation"><a id="btn-show-modify-course-modal" class="btn-new-mdl-course-modal" href="#" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Add Course</a></li>
                        <li role="presentation"><a href="{{ route('dashboard.manager.courses') }}" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Manage</a></li>
                    </ul>
                </div>                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-wrapper collapse in">
            <div class="panel-body" style="padding:0px;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @if (isset($course_catalog_items) && count($course_catalog_items)>0)
                            @foreach($course_catalog_items as $course_catalog_item)
                            <tr>
                                <td class="text-left">
                                    {{$course_catalog_item->code}} - {{$course_catalog_item->name}}
                                </td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="pr-3" data-toggle="tooltip" title="" data-original-title="View"><i class="zmdi zmdi-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-left">
                                    <p>No Courses for this Department</p>                                    
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.manager.modals.modify-course')    
