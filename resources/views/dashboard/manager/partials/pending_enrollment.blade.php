
    <div class="panel panel-default card-view panel-refresh">
        <div class="refresh-container">
            <div class="la-anim-1"></div>
        </div>
        <div class="panel-heading" style="padding: 10px 15px;">
            <div class="pull-left">
                <h4 class="panel-title txt-dark">{{  ($current_user->manager_id != null) ? 'Pending Enrollments' : ''  }}</h4>
            </div>

            @if (($current_user->manager_id != null))

                <div class="pull-right">
                    <!-- <a href="{{ route('dashboard.class',0) }}" class="pull-left inline-block mr-15">
                        <i class="zmdi zmdi-surround-sound" style="font-size:inherit;"></i>
                    </a> -->
                   {{--
                    <div class="pull-left inline-block dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                            <li role="presentation"><a id="btn-show-modify-announcement-modal" class="btn-new-mdl-announcement-modal" href="#" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Add Announcement</a></li>
                            <li role="presentation"><a href="{{ route('dashboard.manager.announcements') }}" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Manage</a></li>
                        </ul>
                    </div>    
                    --}}             
                </div>
                
            @endif
            
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-body" style="padding:0px;">

            <div class="table-wrap sm-data-box-2">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @if (isset($pending_enrollment_approval) && $pending_enrollment_approval->count() > 0))
                            <tr style="font-size: 15px; font-weight: bold">
                                <th>Name</th>
                                <th>Matric Num</th>
                                <th>Course Class</th>
                                <th>Action</th>
                            </tr>
                            @foreach($pending_enrollment_approval as $enrollment)
                            <tr>
                                <td class="text-left">
                                    {{$enrollment->student->first_name}} {{$enrollment->student->last_name}}
                                </td>
                                <td class="text-left">
                                    {{$enrollment->student->matriculation_number}}
                                </td>
                                <td class="text-left">
                                    {{$enrollment->courseClass->code}}  {{ $enrollment->courseClass->name }}
                                </td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="pr-3 btn btn-success btn-show-mdl-enrollment-approval-modal" data-toggle="tooltip" title="" data-val="{{ $enrollment->id }}" data-original-title="View">View</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-left">
                                    <p>No Pending Approval</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @include('dashboard.manager.modals.modify-enrollment-approval')
