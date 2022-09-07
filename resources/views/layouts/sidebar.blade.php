@php
$current_user = Auth()->user();
$profile_picture = null;
if ($current_user && $current_user->student) {
    $profile_picture = $current_user->student->picture_file_path;
}
if ($current_user && $current_user->lecturer) {
    $profile_picture = $current_user->lecturer->picture_file_path;
}
@endphp
<!-- Top Menu Items -->

<!-- beginning of header backgorund and text -->
    @if (isset($app_settings['txt_school_home_color']) && (isset($app_settings['txt_official_website']) || isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_phone'])))
        <div class="navbar-fixed-top col-xs-12 pl-30" style="background-color: {!! $app_settings['txt_school_home_color'] ?? '' !!}; padding-bottom: 10px; height: auto; width: 100%;">
            @if (isset($app_settings['txt_official_website']))
                <div class="pull-left pt-5">
                    <strong> 
                        <a class="inline-block ml-10" target="_blank" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};" href="{{ $app_settings['txt_official_website'] }}" title="Visit {{ $app_settings['txt_official_website'] }}">
                           Go to School Website 
                        </a>
                    </strong> 
                </div>
            @endif
            @if (isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_phone']))
                <div class="pull-right text-left pt-5" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};">
                    @if (isset($app_settings['txt_portal_contact_email']))
                        <strong>Email : </strong>
                        <a class="inline-block" href="mailto:{{ $app_settings['txt_official_website'] }}" title="{{ $app_settings['txt_portal_contact_email'] }}" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};"> 
                            {{ strtolower($app_settings['txt_portal_contact_email']) }} 
                        </a>
                    @endif
                    @if (isset($app_settings['txt_portal_contact_phone']))
                        <strong class="pl-10">Tel : </strong>
                        <a class="inline-block" href="tel:{{ $app_settings['txt_portal_contact_phone'] }}" title="{{ $app_settings['txt_portal_contact_phone'] }}" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};">
                            {{ strtolower($app_settings['txt_portal_contact_phone']) }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    @endif
    <div class="clearfix"></div>
<!-- end of header backgorund and text -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="nav-header-div">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap side-bar-area">
                @php
                    $home = '#';
                    if (auth()->user()->is_platform_admin == 1) {
                        $home = route('dashboard.admin');
                    }
                    if (auth()->user()->lecturer_id != null) {
                        $home = route('dashboard.lecturer');
                    }
                    if (auth()->user()->manager_id != null) {
                        $home = route('dashboard.manager');
                    }
                    if (auth()->user()->student_id != null) {
                        $home = route('dashboard.student');
                    }
                @endphp
                <a href="{{ $home }}">
                    @if (isset($app_settings['file_icon_picture']))
                        <img class="brand-img" src="{{ asset($app_settings['file_icon_picture']) }}" alt="brand" />
                    @else
                        <img class="brand-img" src="{{ asset('dist/img/foresight-logo-sm.fw.png') }}" alt="brand" />
                    @endif
                    <span class="brand-text">
                        {{-- Foresight --}}
                        {!! $app_settings['txt_short_name'] ?? '' !!}
                    </span>
                </a>
            </div>
        </div>
        <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i
                class="zmdi zmdi-menu"></i></a>
        <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>

        <div class="top-nav-search collapse pull-left" style="width: auto;">
            <div class="pull-left">
                <div class="logo-wrap">
                    {{-- <span class="brand-text" style="font-size: 23px;font-weight: 600;text-transform: uppercase;color: black;">Zambezi University</span> --}}
                </div>
            </div>
        </div>

    </div>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right">
        <ul class="nav navbar-right top-nav pull-right">
            <li class="dropdown auth-drp">
                <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img
                        src="{{ $profile_picture ? asset($profile_picture) : asset('dist/img/user-badge.fw.png') }}"
                        alt="user_auth" class="user-auth-img img-circle" /><span class="user-online-status"></span></a>
                <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <li>
                        <a href="{{ route('profile') }}"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="zmdi zmdi-power"></i><span>Log Out</span></a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </div>
    <h4 class="pull-right" style="padding-top: 20px;">{{ $current_user->first_name }} {{ $current_user->last_name }}
    </h4>
</nav>
<!-- /Top Menu Items -->

<!-- Left Sidebar Menu -->
<div class="fixed-sidebar-left" id="side_bar_div">
    <ul class="nav navbar-nav side-nav nicescroll-bar">

        <li class="navigation-header">
            <span>Main Menu</span>
            <i class="zmdi zmdi-more"></i>
        </li>
        @if ($current_user->is_platform_admin == true)
            <li class="">
                <a href="{{ route('dashboard.admin') }}" class="{{ Request::is('dashboard/admin') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                            class="right-nav-text">Admin Dashboard</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
        @endif
        @if ($current_user->student_id != null)
            <li class="">
                <a href="{{ route('dashboard.student') }}"
                    class="{{ Request::is('dashboard/student') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                            class="right-nav-text">Student Dashboard</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
        @endif
        @if ($current_user->lecturer_id != null)
            <li class="">
                <a href="{{ route('dashboard.lecturer') }}"
                    class="{{ Request::is('dashboard/lecturer') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                            class="right-nav-text">Lecturer Dashboard</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <hr class="light-grey-hr mb-10" />
            </li>
        @endif
        @if ($current_user->manager_id != null)
            <li class="">
                <a href="{{ route('dashboard.manager') }}"
                    class="{{ Request::is('dashboard/manager') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                            class="right-nav-text">Manager Dashboard</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
        @endif
        <li class="">
            <a href="{{ route('notifications.index') }}" class="{{ Request::is('notifications') ? 'active' : '' }}">
                <div class="pull-left"><i class="fa fa-bell mr-20"></i><span class="right-nav-text">Notifications</span>
                </div>
                <div class="pull-right"></div>
                <div class="clearfix"></div>
            </a>
        <li>
            <hr class="light-grey-hr mb-10" />
        </li>
        @if ($current_user->is_platform_admin == false)
            <li class="">
                <a href="{{ route('dashboard.archieves') }}"
                    class="{{ Request::is('dashboard/archieves') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                            class="right-nav-text">Archieves</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <hr class="light-grey-hr mb-10" />
            </li>
        @endif
        @if ($current_user->student_id != null)
            @if (!empty($app_settings) && $app_settings['cbx_class_enrollment'] != null)
                <li class="">
                    <a href="#" id="btn-show-modify-student-modal" href="#"
                        class="btn-new-mdl-enrollment-modal">
                        <div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span
                                class="right-nav-text">Enroll in class</span></div>
                        <div class="pull-right"></div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li>
                    <hr class="light-grey-hr mb-10" />
                </li>
            @endif
            <!-- Get current class list -->
            @if (isset($class_schedules))

                <li class="navigation-header">
                    <span> {{ Request::is('dashboard/archieves') ? 'Archieved Classes' : 'Online Classes' }}</span>
                    <i class="zmdi zmdi-more"></i>
                </li>
                @foreach ($class_schedules as $class_schedule_item)
                    <li class="">
                        <a href="{{ route('dashboard.class', $class_schedule_item->id) }}"
                            class="{{ Request::is('dashboard/class/' . $class_schedule_item->id . '*') ? 'active' : '' }}">
                            <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                                    class="right-nav-text">{{ $class_schedule_item->code }}</span></div>
                            <div class="pull-right"></div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                @endforeach
            @endif
        @endif

        @if ($current_user->lecturer_id != null)
            @if (isset($class_schedules))
                @php
                    $class_type = 'Online Classes';
                    $class = $class_schedules->first();
                    if ($class && $class->semester_id != optional($current_semester)->id) {
                        $class_type = 'Archieved Classes';
                    }
                @endphp
                <li class="navigation-header">
                    <span>{{$class_type}}</span>
                    <i class="zmdi zmdi-more"></i>
                </li>
                @foreach ($class_schedules as $class_schedule_item)
                    <li class="">
                        <a href="{{ route('dashboard.class', $class_schedule_item->id) }}"
                            class="{{ Request::is('dashboard/class/' . $class_schedule_item->id . '*') ? 'active' : '' }}">
                            <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                                    class="right-nav-text">{{ $class_schedule_item->code }}</span></div>
                            <div class="pull-right"></div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                @endforeach
            @endif
        @endif

        @if ($current_user->manager_id != null)
            <li class="">
                <a href="{{ route('dashboard.manager.students') }}"
                    class="{{ Request::is('dashboard/manager/students') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-accounts-outline mr-20"></i><span
                            class="right-nav-text">Students</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="">
                <a href="{{ route('dashboard.manager.lecturers') }}"
                    class="{{ Request::is('dashboard/manager/lecturers') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-pin-account mr-20"></i><span
                            class="right-nav-text">Lecturers</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="">
                <a href="{{ route('dashboard.manager.courses') }}"
                    class="{{ Request::is('dashboard/manager/courses') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-collection-bookmark mr-20"></i><span
                            class="right-nav-text">Courses</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="">
                <a href="{{ route('dashboard.manager.classes') }}"
                    class="{{ Request::is('dashboard/manager/classes') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span
                            class="right-nav-text">Course Classes</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="">
                <a href="{{ route('dashboard.manager.announcements') }}"
                    class="{{ Request::is('dashboard/manager/announcements') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-surround-sound mr-20"></i><span
                            class="right-nav-text">Announcements</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="">
                <a href="{{ route('dashboard.manager.calendars') }}"
                    class="{{ Request::is('dashboard/manager/calendars') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-notifications-active mr-20"></i><span
                            class="right-nav-text">Calendar</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            @if (isset($class_schedules))
                <li>
                    <hr class="light-grey-hr mb-10" />
                </li>

                @php
                    $class_type = 'Online Classes';
                    $class = $class_schedules->first();
                    if ($class && $class->semester_id != optional($current_semester)->id) {
                        $class_type = 'Archieved Classes';
                    }
                @endphp
                <li class="navigation-header">
                    <span>{{ $class_type }}</span>
                    <i class="zmdi zmdi-more"></i>
                </li>
                @foreach ($class_schedules as $class_schedule_item)
                    <li class="">
                        <a href="{{ route('dashboard.class', $class_schedule_item->id) }}"
                            class="{{ Request::is('dashboard/class/' . $class_schedule_item->id . '*') ? 'active' : '' }}">
                            <div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span
                                    class="right-nav-text">{{ $class_schedule_item->code }}</span></div>
                            <div class="pull-right"></div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                @endforeach
            @endif
        @endif

        @if ($current_user->is_platform_admin == true)
            <li class="navigation-header">
                <span>Administrator</span>
                <i class="zmdi zmdi-more"></i>
            </li>
            <li class="">
                <a href="{{ route('dashboard.admin-settings') }}"
                    class="{{ Request::is('dashboard/admin/settings*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-border-color mr-20"></i><span
                            class="right-nav-text">Settings</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li class="">
                <a href="{{ route('departments.index') }}"
                    class="{{ Request::is('departments*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-home mr-20"></i><span
                            class="right-nav-text">Departments</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li class="">
                <a href="{{ route('semesters.index') }}" class="{{ Request::is('semesters*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-calendar-note mr-20"></i><span
                            class="right-nav-text">Semesters</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <!-- <li><hr class="light-grey-hr mb-10"/></li> -->
            <li class="">
                <a href="{{ route('dashboard.users') }}"
                    class="{{ Request::is('dashboard/users*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-accounts-outline mr-20"></i><span
                            class="right-nav-text">User Accounts</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li class="">
                <a href="{{ route('faqs.index') }}" class="{{ Request::is('faqs*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-help mr-20"></i><span class="right-nav-text">FAQ &
                            Help</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li class="">
                <a href="{{ route('announcements.index') }}"
                    class="{{ Request::is('announcements*') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-surround-sound mr-20"></i><span
                            class="right-nav-text">Announcements</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li class="">
                <a href="{{ route('levels.index') }}" class="{{ Request::is('levels') ? 'active' : '' }}">
                    <div class="pull-left"><i class="zmdi zmdi-surround-sound mr-20"></i><span
                            class="right-nav-text">Levels</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <!--
                <li class="">
                    <a href="{{ route('departments.index') }}" class="{{ Request::is('departments*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-home mr-20"></i><span class="right-nav-text">Departments</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('courses.index') }}" class="{{ Request::is('courses*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-collection-bookmark mr-20"></i><span class="right-nav-text">Courses</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('courseClasses.index') }}" class="{{ Request::is('courseClasses*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span class="right-nav-text">Course Classes</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('classMaterials.index') }}" class="{{ Request::is('classMaterials*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-collection-plus mr-20"></i><span class="right-nav-text">Class Materials</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('grades.index') }}" class="{{ Request::is('grades*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-folder-outline mr-20"></i><span class="right-nav-text">Grades</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('calendarEntries.index') }}" class="{{ Request::is('calendarEntries*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-notifications-active mr-20"></i><span class="right-nav-text">Calendar Entries</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('lecturers.index') }}" class="{{ Request::is('lecturers*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-pin-account mr-20"></i><span class="right-nav-text">Lecturers</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('managers.index') }}" class="{{ Request::is('managers*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-assignment-account mr-20"></i><span class="right-nav-text">Managers</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('students.index') }}" class="{{ Request::is('students*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-accounts-list mr-20"></i><span class="right-nav-text">Students</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('submissions.index') }}" class="{{ Request::is('submissions*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-file-plus mr-20"></i><span class="right-nav-text">Submissions</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('enrollments.index') }}" class="{{ Request::is('enrollments*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-accounts-list-alt mr-20"></i><span class="right-nav-text">Enrollments</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('forums.index') }}" class="{{ Request::is('forums*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-comments mr-20"></i><span class="right-nav-text">Forums</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li>

                <li class="">
                    <a href="#" class="{{ Request::is('users*') ? 'active' : '' }}">
                        <div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">Users</span></div><div class="pull-right"></div><div class="clearfix"></div>
                    </a>
                </li> -->
        @endif
    </ul>
</div>
