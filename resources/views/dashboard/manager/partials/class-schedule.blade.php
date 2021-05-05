
    <div class="panel panel-default card-view panel-refresh">
        <div class="refresh-container">
            <div class="la-anim-1"></div>
        </div>
        <div class="panel-heading" style="padding: 10px 15px;">
            <div class="pull-left">
                <h4 class="panel-title txt-dark">Class Schedule</h4>
            </div>
            <div class="pull-right">
                <!-- <a href="{{ route('dashboard.class',0) }}" class="pull-left inline-block mr-15">
                    <i class="zmdi zmdi-surround-sound" style="font-size:inherit;"></i>
                </a> -->
                <div class="pull-left inline-block dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                        <li role="presentation"><a id="btn-show-modify-class-modal" href="#" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Add Class</a></li>
                        <li role="presentation"><a href="{{ route('dashboard.manager.classes') }}" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Manage</a></li>
                    </ul>
                </div>                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-body" style="padding:0px;">
            <div class="table-wrap sm-data-box-2">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @if (isset($class_schedules) && count($class_schedules)>0)
                            @foreach($class_schedules as $class_schedule)
                            <tr>                                
                                <td class="text-left">
                                    {{$class_schedule->code}} - {{$class_schedule->name}}
                                    <p class="txt-primary" style="font-size:70%"> 
                                        @if ($class_schedule->monday_time!=null) 
                                            {{ "Mon - ".$class_schedule->monday_time }}
                                        @endif
                                        @if ($class_schedule->tuesday_time!=null) 
                                            {{ " | Tue - ".$class_schedule->tuesday_time }}
                                        @endif
                                        @if ($class_schedule->wednesday_time!=null) 
                                            {{ " | Wed - ".$class_schedule->wednesday_time }}
                                        @endif
                                        @if ($class_schedule->thursday_time!=null) 
                                            {{ " | Thur - ".$class_schedule->thursday_time }}
                                        @endif
                                        @if ($class_schedule->friday_time!=null) 
                                            {{ " | Fri - ".$class_schedule->friday_time }}
                                        @endif
                                        @if ($class_schedule->saturday_time!=null) 
                                            {{ " | Sat - ".$class_schedule->saturday_time }}
                                        @endif
                                        @if ($class_schedule->sunday_time!=null) 
                                            {{ " | Sun - ".$class_schedule->sunday_time }}
                                        @endif
                                    </p>
                                </td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="pr-3" data-toggle="tooltip" title="" data-original-title="View"><i class="zmdi zmdi-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-left">
                                    <p>No Class Schedule</p>                                    
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
