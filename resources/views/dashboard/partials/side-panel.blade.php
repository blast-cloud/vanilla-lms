                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body text-center">
                            @if (isset($app_settings['file_high_res_picture']))
                            {{-- <img src= "{{ asset('dist/img/logouzzz.jpg') }}" style="width:100px;height:100px;" class="user-auth-img"> --}}
                            <img src= "{{ asset($app_settings['file_high_res_picture']) }}" style="width:100px;height:100px;" class="user-auth-img">
                            @endif
                            <h5 class="">
                                {{-- Zambezi University --}}
                                {!! $app_settings['txt_long_name'] ?? '' !!}
                            </h5>
                            <p class="muted">
                                {{-- eLearning Portal --}}
                                {!! $app_settings['txt_app_name'] ?? '' !!}
                            </p>
                            {{-- <p class="" style="font-size:80%">Current Semester: 01-2020/21</p> --}}
                        </div>
                    </div>
                </div>



                @if (isset($announcements) && isset($department) && $current_user->manager_id == null)

                @include('dashboard.manager.partials.announcements')
                    
                @endif


                <div class="panel panel-default card-view">
                    <div class="panel-heading" style="padding: 10px 5px 5px 15px;">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Quick Links</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body" style="padding: 10px 5px 5px 15px;">
                            <ul class="list-icons" style="font-size:95%">
                                @if (isset($app_settings['txt_official_website']))
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i> <a href="{{$app_settings['txt_official_website']}}" class="text-primary" >Main Website</a></li>
                                @endif
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i> <a href="{{ route('help') }}" class="text-primary" >Help</a></li>
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i> <a href="{{ route('faq') }}" class="text-primary" >FAQ</a></li>   
                            </ul>
                            @if ($current_user->is_platform_admin == true || $current_user->manager_id != null )   
                            <div class="pull-left" style="padding-top: 10px; padding-bottom: 7px">
                                <h6 class="panel-title txt-dark">Download Links</h6>
                            </div>
                            <div class="clearfix"></div>
               
                            <ul class="list-icons" style="font-size:95%">
                                             
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i><span><a href="{{asset('csv/dep_upload_cvs_format.csv')}}" class="text-primary">Department bulk upload CSV format</a></span></li>
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i><span><a href="{{asset('csv/lecturer_user_upload_cvs_format.csv')}}" class="text-primary">Lecturer bulk upload CSV format</a></span></li>
                                <li class="mb-5"><i class="fa fa-genderless text-primary mr-5"></i><span><a href="{{asset('csv/student_user_upload_cvs_format.csv')}}" class="text-primary">Student bulk upload CSV format</a></span></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>

                @if (isset($app_settings['txt_portal_contact_phone']) || isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_name']))
                <div class="panel panel-default card-view">
                    <div class="panel-heading pb-5" style="">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Help & Support</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pt-5" style="">
                            <p>If you are having challenges with the portal please contact;</p>
                            @if (isset($app_settings['txt_portal_contact_name']))
                            <i class="fa fa-user ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_name'] }}<br/>
                            @endif
                            @if (isset($app_settings['txt_portal_contact_phone']))
                            <i class="fa fa-phone ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_phone'] }}<br/>
                            @endif
                            @if (isset($app_settings['txt_portal_contact_email']))
                            <i class="fa fa-envelope ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_email'] }}<br/>
                            @endif
                        </div>
                    </div>
                </div>
                @endif