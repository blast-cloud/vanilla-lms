@extends('layouts.app')


@section('title_postfix')
Admin Settings
@stop

@section('page_title')
Admin Settings
@stop



@section('content')
    
        @include('flash::message')

    
        <div class="col-sm-9">

            {!! Form::open(['route' => 'dashboard.admin-settings-process','enctype'=>"multipart/form-data",'class'=>'']) !!}
            @csrf

            <div class="tab-struct custom-tab-1 mt-20">
                <ul role="tablist" class="nav nav-pills" id="myTabs_6">
                    <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_6" href="#home_6">General Settings</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_5" role="tab" href="#profile_5" aria-expanded="false">Registration & Enrollments</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_6" role="tab" href="#profile_6" aria-expanded="false">Text</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7" role="tab" href="#profile_7" aria-expanded="false">Graphics</a></li>
                </ul>
                <div class="tab-content" id="myTabContent_6">
    
                    <div id="home_6" class="tab-pane fade active in" role="tabpanel">                                                  
                        <div class="form-wrap">
                            <div class="col-sm-11">
                                <br/>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_app_name">Application Title</label>
                                    <div class="col-sm-9">
                                        {!! Form::text('txt_app_name', $db_settings['txt_app_name']??"", ['id'=>'txt_app_name','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_long_name">Organization Name</label>
                                    <div class="col-sm-9">
                                        {!! Form::text('txt_long_name', $db_settings['txt_long_name']??"", ['id'=>'txt_long_name','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_short_name">Short Name</label>
                                    <div class="col-sm-4">
                                        {!! Form::text('txt_short_name', $db_settings['txt_short_name']??"", ['id'=>'txt_short_name','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_official_website">Official Website</label>
                                    <div class="col-sm-6">
                                        {!! Form::text('txt_official_website', $db_settings['txt_official_website']??"", ['id'=>'txt_official_website','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_official_email">Offical Email Address</label>
                                    <div class="col-sm-6">
                                        {!! Form::text('txt_official_email', $db_settings['txt_official_email']??"", ['id'=>'txt_official_email','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_portal_contact_name">Portal Contact Name</label>
                                    <div class="col-sm-6">
                                        {!! Form::text('txt_portal_contact_name', $db_settings['txt_portal_contact_name']??"", ['id'=>'txt_portal_contact_name','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_portal_contact_email">Portal Contact Email</label>
                                    <div class="col-sm-6">
                                        {!! Form::text('txt_portal_contact_email', $db_settings['txt_portal_contact_email']??"", ['id'=>'txt_portal_contact_email','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_portal_contact_phone">Portal Contact Phone</label>
                                    <div class="col-sm-6">
                                        {!! Form::number('txt_portal_contact_phone', $db_settings['txt_portal_contact_phone']??"", ['id'=>'txt_portal_contact_phone','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_school_max_level">Max School Level</label>
                                    <div class="col-sm-6">
                                        {!! Form::number('txt_school_max_level', $db_settings['txt_school_max_level']??"", ['id'=>'txt_school_max_level','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_school_home_color">School Primary Color</label>
                                    <div class="col-sm-6">
                                        {!! Form::color('txt_school_home_color', $db_settings['txt_school_home_color']??"", ['id'=>'txt_school_home_color','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_school_text_color">Text Color</label>
                                    <div class="col-sm-6">
                                        {!! Form::color('txt_school_text_color', $db_settings['txt_school_text_color']??"", ['id'=>'txt_school_text_color','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {{-- <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_display_course_list">Display Online Courses on Home Page</label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_display_course_list', 1, $db_settings['cbx_display_course_list']??"", ['id'=>'cbx_display_course_list', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_display_lecturer_profiles">Display Lecturer Profiles on Home Page</label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_display_lecturer_profiles', 1, $db_settings['cbx_display_lecturer_profiles']??"", ['id'=>'cbx_display_lecturer_profiles', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div id="profile_5" class="tab-pane fade" role="tabpanel">
                        <div class="form-wrap">
                            <div class="col-sm-11">
                                <br/>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="txt_maximum_enrollment_limit">Maximum Enrolled Students Per Class</label>
                                    <div class="col-sm-2">
                                        {!! Form::text('txt_maximum_enrollment_limit', $db_settings['txt_maximum_enrollment_limit']??"50", ['id'=>'txt_maximum_enrollment_limit','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                {{-- <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_require_enrollment_confirmation">Require Enrollment Confirmation</label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_require_enrollment_confirmation', 1, $db_settings['cbx_require_enrollment_confirmation']??"", ['id'=>'cbx_require_enrollment_confirmation', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div> --}}

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_allow_lecturer_registration">Allow Lecturer Self Registraion </label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_allow_lecturer_registration', 1, $db_settings['cbx_allow_lecturer_registration']??"", ['id'=>'cbx_allow_lecturer_registration', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_allow_student_registration">Allow Student Self Registration</label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_allow_student_registration', 1, $db_settings['cbx_allow_student_registration']??"", ['id'=>'cbx_allow_student_registration', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-5" for="cbx_class_enrollment">Allow Student Self Enrollment</label>
                                    <div class="col-sm-1">
                                        {!! Form::checkbox('cbx_class_enrollment', 1, $db_settings['cbx_class_enrollment']??"", ['id'=>'cbx_class_enrollment', 'class' => 'form-control','style'=>'height:24px;']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="profile_6" class="tab-pane fade" role="tabpanel">
                        <div class="form-wrap">
                            <div class="col-sm-11">
                                <br/>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_welcome_text">Welcome Text</label>
                                    <div class="col-sm-9">
                                        {!! Form::textarea('txt_welcome_text', $db_settings['txt_welcome_text']??"", ['id'=>'txt_welcome_text','rows'=>'4','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                {{-- <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_registration_text">Registration Text</label>
                                    <div class="col-sm-9">
                                        {!! Form::textarea('txt_registration_text', $db_settings['txt_registration_text']??"", ['id'=>'txt_registration_text','rows'=>'4','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_enrollment_text">Class Enrollment Text</label>
                                    <div class="col-sm-9">
                                        {!! Form::textarea('txt_enrollment_text', $db_settings['txt_enrollment_text']??"", ['id'=>'txt_enrollment_text','rows'=>'4','class' => 'form-control']) !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div id="profile_7" class="tab-pane fade" role="tabpanel">
                        <div class="form-wrap">
                            <div class="col-sm-11">
                                <br/>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for=""></label>
                                    <div class="col-sm-9">
                                    @if (isset($db_settings['file_high_res_picture']))
                                    <img src="{{ asset($db_settings['file_high_res_picture']) }}" /><br/>
                                    <a style="font-size:70%" href="#" class="text-info reset-settings-value" data-val="file_high_res_picture">Remove Image</a>
                                    @else
                                    No Image Uploaded
                                    @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="file_high_res_picture">High Resolution Logo</label>
                                    <div class="col-sm-9">
                                        {!! Form::file('file_high_res_picture', ['id'=>'file_high_res_picture', 'class' => 'custom-file-input']) !!}
                                    </div>
                                </div>
                                
                                <hr class="light-grey-hr mb-10">

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for=""></label>
                                    <div class="col-sm-9">
                                    @if (isset($db_settings['file_icon_picture']))
                                    <img src="{{ asset($db_settings['file_icon_picture']) }}" /><br/>
                                    <a style="font-size:70%" href="#" class="text-info reset-settings-value" data-val="file_icon_picture">Remove Image</a>
                                    @else
                                    No Image Uploaded
                                    @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="file_icon_picture">Icon Logo</label>
                                    <div class="col-sm-9">
                                        {!! Form::file('file_icon_picture', ['id'=>'file_icon_picture', 'class' => 'custom-file-input']) !!}
                                    </div>
                                </div>

                                <hr class="light-grey-hr mb-10">

                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for=""></label>
                                    <div class="col-sm-9">
                                    @if (isset($db_settings['file_landing_page_picture']))
                                    <img src="{{ asset($db_settings['file_landing_page_picture']) }}" width="50%" height="50%" /><br/>
                                    <a style="font-size:70%" href="#" class="text-info reset-settings-value" data-val="file_landing_page_picture">Remove Image</a>
                                    @else
                                    No Image Uploaded
                                    @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="control-label mb-10 col-sm-3" for="file_landing_page_picture">Landing Page Image</label>
                                    <div class="col-sm-9">
                                        {!! Form::file('file_landing_page_picture', ['id'=>'file_landing_page_picture', 'class' => 'custom-file-input']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
    
            <div class="col-sm-11">
                <hr class="light-grey-hr mb-10">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>

@endsection



@section('js-112')
<script type="text/javascript">
$(document).ready(function() {

    //Reset Action
    $('.reset-settings-value').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this item?")){
            $.get("{{ route('dashboard.admin-delete-setting','') }}/"+itemId).done(function( data ) {
                window.alert("The item has been removed.");
                location.reload(true);
            });
        }
    });

});
</script>
@endsection