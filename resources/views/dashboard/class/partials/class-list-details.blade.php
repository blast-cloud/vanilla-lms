
        @if (isset($classDetailItem) && $classDetailItem!=null)
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading" style="padding: 10px 15px;">
                            <div class="pull-left">
                                <h4 class="panel-title txt-dark">{{ $classDetailItem->code}} :: {{ $classDetailItem->name}} </h4>
                                @if (isset($current_user) && $current_user->lecturer_id == $classDetailItem->lecturer_id)
                                <span style="font-size:70%" class="muted txt-danger">You are assigned to teach this class</span>
                                @endif
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('dashboard.class',$classDetailItem->id) }}" class="btn btn-xs btn-primary pull-left inline-block mr-15">
                                    <i class="zmdi zmdi-square-right" style="font-size:inherit;color:white;"></i>&nbsp; View
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="panel-body" style="padding: 10px 15px;">
                            <div class="row">
                                <div class="col-sm-10">
                                
                                    <ul class="list-icons" style="font-size:95%">
                                        @if (!empty($classDetailItem->email_address))
                                        <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Class Email: <span class="text-primary">{{ $classDetailItem->email_address }}</span></li>
                                        @endif
                                        @if (!empty($classDetailItem->telephone))
                                        <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Class Phone#: <span class="text-primary">{{ $classDetailItem->telephone }}</span></li>
                                        @endif
                                        <!-- <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Lecture Period: <span class="text-info">Mon, Wed, Fri (3PM to 4PM)</span></li> -->
                                        @if (!empty($classDetailItem->next_lecture_date))
                                        <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Next Lecture: <span id="spn_next_lecture_date" class="text-warning">{{ $classDetailItem->next_lecture_date}}</span></li>
                                        @endif
                                        @if (!empty($classDetailItem->next_exam_date))
                                        <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Next Exam Date: <span id="spn_next_exam_date" class="text-warning">{{ $classDetailItem->next_exam_date}}</span></li>
                                        @endif
                                        <!-- <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Assignment #1 is due Monday, 12-Jun-21 </span></li> -->
                                        <!-- <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Enrolled Students: <span class="text-danger">50</span> </li> -->

                                        <li>
                                            @if (isset($current_user) && $current_user->student_id != null)                                                    
                                                @php
                                                    $message = $activity->get_activity_score($classDetailItem->id, $current_user->student_id);
                                                @endphp
                                                @if($message == null)
                                                    <i class="text-danger fa fa-warning mr-5"></i>
                                                    <span class="text-danger">You seem not to be participating in this class. Kindly followup on reading materials, assignments, and use the discussion forum if you have questions.</span>
                                                @endif
                                                @if($message == 'low')
                                                    <i class="text-danger fa fa-warning mr-5"></i>
                                                    <span class="text-danger">Your participation in this class is low, and it might affect your final score. Kindly followup on reading materials, assignments, and use the discussion forum if you have questions.</span>
                                                @endif
                                                @if($message == 'moderate')
                                                    {{-- <span class="text-danger">Your participation in this class is moderate</span> --}}
                                                @endif
                                                @if($message == 'high')
                                                    <i class="text-primary fa fa-thimbs-o-up mr-5"></i>
                                                    <span class="text-primary">Your particpation in this class is high, please keep it up.</span>
                                                @endif
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div class="col-sm-6 text-right">
                                    <p style="font-size:80%;" class="text-danger muted">Class outline and notes have NOT been uploaded.</p>
                                    <p style="font-size:80%;" class="text-danger muted">No lectures have been uploaded</p>
                                    <p style="font-size:80%;" class="text-danger muted">No assignments have been assigned</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
