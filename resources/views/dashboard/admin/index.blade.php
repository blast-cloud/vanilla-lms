@extends('layouts.app')


@section('title_postfix')
    Admin Dashboard
@stop

@section('page_title')
    Admin Dashboard <a href="" class="pull-right btn btn-danger btn-change-student-level-modal"> change student
        levels</a>
@stop


@section('content')

    @include('flash::message')


    <div class="col-sm-9">

        @php
            // dd (isset($current_semester));
            // dd($current_semester);
        @endphp

        @if (isset($current_semester) && $current_semester == null)
            <div class="text-left alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                No current <strong>Semester</strong> set in the system. You have to setup the current semester.
                <a id="btn-new-semester" href="#"
                    class="ma-10 btn btn-xs btn-danger btn-new-mdl-semester-modal pull-right"><i
                        class="zmdi zmdi-home"></i>&nbsp;Start New Semester</a>
            </div>
        @endif

        {{-- @include('dashboard.admin.partials.semesters') --}}
        <div class="row">
            <div class="inside" style=" display:flex !important;flex-basis:100% !important;flex-wrap:wrap !important;">

                <div class="col-md-6">
                    @include('dashboard.admin.partials.announcements')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.managers')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.lecturers')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.departments')
                </div>
            </div>

        </div>

    </div>
    <div class="col-sm-3">

        @include('dashboard.partials.side-panel')
    </div>

@section('js-113')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".btn-change-student-level-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                swal({
                        title: "Are you sure you want to change all students level to the next level?",
                        text: "This is an irriversible action!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = '<div class="loader2" id="loader-1"></div>';
                            swal({
                                title: 'Please Wait !',
                                content: wrapper,
                                buttons: false,
                                closeOnClickOutside: false
                            });
                            let endPointUrl = "{{ route('api.levels.upgrade') }}";

                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());

                            $.ajax({
                                url: endPointUrl,
                                type: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.errors) {
                                        console.log(result.errors)
                                    } else {
                                        swal("Done!",
                                            "The Student levels changed successfully!",
                                            "success");
                                        setTimeout(() => {
                                            location.reload(true);
                                        }, 2000);
                                    }
                                },
                            });
                        }
                    });
            });
        })
    </script>
@endsection



@endsection
