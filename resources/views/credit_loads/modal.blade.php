<div class="modal fade" id="mdl-credit_load-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="lbl-credit_load-modal-title" class="modal-title">credit_load</h4>
            </div>

            <div class="modal-body">
                <div id="div-credit_load-modal-error" class="alert alert-danger" role="alert"></div>

                <form class="form-horizontal" id="frm-credit_load-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <div class="spinner1">
                                <div class="loader" id="loader-1"></div>
                            </div>
                            <input type="hidden" id="txt-credit_load-primary-id" value="0" />
                            <div id="div-show-txt-credit_load-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        @include('credit_loads.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-credit_load-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        @include('credit_loads.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div id="div-save-mdl-credit_load-modal">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-credit-load-modal"
                        value="add">Save</button>
                </div>
               
            </div>

        </div>
    </div>
</div>

@section('js-113')
    <script type="text/javascript">
        $(document).ready(function() {

            //Show Modal for New Entry
            $(document).on('click', ".btn-new-mdl-credit-load-modal", function(e) {
                $('.spinner1').hide();
                $('#div-save-mdl-credit_load-modal').show()
                $('#div-credit_load-modal-error').hide();
                $('.input-border-error').removeClass("input-border-error");
                $('#mdl-credit_load-modal').modal('show');
                $('#frm-credit_load-modal').trigger("reset");
                $('#txt-credit_load-primary-id').val(0);

                $('#div-show-txt-credit_load-primary-id').hide();
                $('#div-edit-txt-credit_load-primary-id').show();
            });

            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-credit-load-modal", function(e) {
                e.preventDefault();
                $('.spinner1').show();
                $('#div-save-mdl-credit-load-modal').hide()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-show-txt-credit_load-primary-id').show();
                $('#div-edit-txt-credit_load-primary-id').hide();
                let itemId = $(this).attr('data-val');

                // $.get( "{{ URL::to('/') }}/api/credit_loads/"+itemId).done(function( data ) {
                $.get("{{ URL::to('/') }}/api/credit_loads/" + itemId).done(function(response) {
                    $('#div-credit_load-modal-error').hide();
                    $('#mdl-credit_load-modal').modal('show');
                    $('#frm-credit_load-modal').trigger("reset");
                    $('#txt-credit_load-primary-id').val(response.data.id);
                    $('.spinner1').hide();
                    $('#spn_credit_load_name').html(response.data.name);
                    $('#spn_credit_load_credit_load').html(response.data.credit_load);
                });
            });

            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-credit-load-modal", function(e) {
                e.preventDefault();
                $('.spinner1').show();
                $('#div-save-mdl-credit-load-modal').show()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $('.input-border-error').removeClass("input-border-error");
                $('#div-show-txt-credit_load-primary-id').hide();
                $('#div-edit-txt-credit_load-primary-id').show();
                let itemId = $(this).attr('data-val');

                // $.get( "{{ URL::to('/') }}/api/credit_loads/"+itemId).done(function( data ) {
                $.get("{{ URL::to('/') }}/api/credit_loads/" + itemId).done(function(response) {
                    $('#div-credit_load-modal-error').hide();
                    $('#mdl-credit_load-modal').modal('show');
                    $('#frm-credit_load-modal').trigger("reset");
                    $('#txt-credit_load-primary-id').val(response.data.id);
                    $('#credit_load_name').val(response.data.name);
                    $('#credit_load_credit_load').val(response.data.credit_load);
                    // $('#').val(response.data.);
                    // $('#').val(response.data.);
                    $('.spinner1').hide();
                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-credit-load-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                swal({
                        title: "Are you sure you want to delete this credit load?",
                        text: "This is an irriversible action!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let endPointUrl = "{{ route('credit_loads.destroy', 0) }}" + itemId;

                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('_method', 'DELETE');

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
                                        swal("Done!", "The credit load record has been deleted!",
                                            "success");
                                        location.reload(true);
                                    }
                                },
                            });
                        }
                    });
            });

            //Save details
            $('#btn-save-mdl-credit-load-modal').click(function(e) {
                e.preventDefault();
                $('.spinner1').show();
                //check for network connctivity
                if (!window.navigator.onLine) {
                    $('#offline').fadeIn(300);
                    return;
                } else {
                    $('#offline').fadeOut(300);
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let actionType = "POST";
                // let endPointUrl = "{{ URL::to('/') }}/api/credit_loads/create";
                let endPointUrl = "{{ route('credit_loads.store') }}";
                let primaryId = $('#txt-credit-load-primary-id').val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId > 0) {
                    actionType = "PUT";
                    // endPointUrl = "{{ URL::to('/') }}/api/credit_loads/"+itemId;
                    endPointUrl = "{{ route('credit_loads.update', 0) }}" + primaryId;
                    formData.append('id', primaryId);
                }
                formData.append('name', $('#credit_load_name').val())
                formData.append('credit_load', $('#credit_load_credit_load').val())
                formData.append('_method', actionType);
                // formData.append('', $('#').val());
                // formData.append('', $('#').val());

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
                            $('.spinner1').hide();
                            $('#div-credit-load-modal-error').html('');
                            $('#div-credit-load-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-credit-load-modal-error').append('<li class="">' +
                                    value + '</li>');
                                $('#credit_load_' + key).addClass("input-border-error");

                                $('#credit_load_' + key).keyup(function(e) {
                                    if ($('#credit_load_' + key).val() != '') {
                                        $('#credit_load_' + key).removeClass(
                                            "input-border-error")
                                    } else {
                                        $('#credit_load_' + key).addClass(
                                            "input-border-error")
                                    }
                                });
                            });
                        } else {
                            $('.spinner1').hide();
                            $('#div-credit-load-modal-error').hide();
                            window.setTimeout(function() {
                                swal("Done!", "The credit load record saved successfully!",
                                    "success");
                                $('#div-credit_load-modal-error').hide();
                                location.reload(true);
                            }, 28);
                        }
                    },
                    error: function(data) {
                        $('.spinner1').hide();
                        console.log(data);
                    }
                });
            });

        //Change Student credit_load
        $(document).on('click', ".btn-change-student-credit-load-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });

            let itemId = $(this).attr('data-val');
            swal({
                    title: "Are you sure you want to change all students credit load to the next credit_load?",
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
                        let endPointUrl = "{{ route('api.credit_loads.upgrade') }}";

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
                                        "The Student credit loads changed successfully!",
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
});
    </script>
@endsection
