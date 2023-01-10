<div class="modal fade" id="mdl-level-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="lbl-level-modal-title" class="modal-title">level</h4>
            </div>

            <div class="modal-body">
                <div id="div-level-modal-error" class="alert alert-danger" role="alert"></div>

                <form class="form-horizontal" id="frm-level-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <div class="spinner1">
                                <div class="loader" id="loader-1"></div>
                            </div>
                            <input type="hidden" id="txt-level-primary-id" value="0" />
                            <div id="div-show-txt-level-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        @include('levels.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-level-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        @include('levels.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div id="div-save-mdl-level-modal">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-level-modal"
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
            $(document).on('click', ".btn-new-mdl-level-modal", function(e) {
                $('.spinner1').hide();
                $('#div-save-mdl-level-modal').show()
                $('#div-level-modal-error').hide();
                $('.input-border-error').removeClass("input-border-error");
                $('#mdl-level-modal').modal('show');
                $('#frm-level-modal').trigger("reset");
                $('#txt-level-primary-id').val(0);

                $('#div-show-txt-level-primary-id').hide();
                $('#div-edit-txt-level-primary-id').show();
            });

            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-level-modal", function(e) {
                e.preventDefault();
                $('.spinner1').show();
                $('#div-save-mdl-level-modal').hide()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-show-txt-level-primary-id').show();
                $('#div-edit-txt-level-primary-id').hide();
                let itemId = $(this).attr('data-val');

                // $.get( "{{ URL::to('/') }}/api/levels/"+itemId).done(function( data ) {
                $.get("{{ URL::to('/') }}/api/levels/" + itemId).done(function(response) {
                    $('#div-level-modal-error').hide();
                    $('#mdl-level-modal').modal('show');
                    $('#frm-level-modal').trigger("reset");
                    $('#txt-level-primary-id').val(response.data.id);
                    $('.spinner1').hide();
                    $('#spn_level_name').html(response.data.name);
                    $('#spn_level_level').html(response.data.level);
                });
            });

            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-level-modal", function(e) {
                e.preventDefault();
                $('.spinner1').show();
                $('#div-save-mdl-level-modal').show()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $('.input-border-error').removeClass("input-border-error");
                $('#div-show-txt-level-primary-id').hide();
                $('#div-edit-txt-level-primary-id').show();
                let itemId = $(this).attr('data-val');

                // $.get( "{{ URL::to('/') }}/api/levels/"+itemId).done(function( data ) {
                $.get("{{ URL::to('/') }}/api/levels/" + itemId).done(function(response) {
                    $('#div-level-modal-error').hide();
                    $('#mdl-level-modal').modal('show');
                    $('#frm-level-modal').trigger("reset");
                    $('#txt-level-primary-id').val(response.data.id);
                    $('#level_name').val(response.data.name);
                    $('#level_level').val(response.data.level);
                    // $('#').val(response.data.);
                    // $('#').val(response.data.);
                    $('.spinner1').hide();
                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-level-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                swal({
                        title: "Are you sure you want to delete this level?",
                        text: "This is an irriversible action!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let endPointUrl = "{{ route('levels.destroy', 0) }}" + itemId;

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
                                        swal("Done!", "The level record has been deleted!",
                                            "success");
                                        location.reload(true);
                                    }
                                },
                            });
                        }
                    });
            });

            //Save details
            $('#btn-save-mdl-level-modal').click(function(e) {
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
                // let endPointUrl = "{{ URL::to('/') }}/api/levels/create";
                let endPointUrl = "{{ route('levels.store') }}";
                let primaryId = $('#txt-level-primary-id').val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId > 0) {
                    actionType = "PUT";
                    // endPointUrl = "{{ URL::to('/') }}/api/levels/"+itemId;
                    endPointUrl = "{{ route('levels.update', 0) }}" + primaryId;
                    formData.append('id', primaryId);
                }
                formData.append('name', $('#level_name').val())
                formData.append('level', $('#level_level').val())
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
                            $('#div-level-modal-error').html('');
                            $('#div-level-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-level-modal-error').append('<li class="">' +
                                    value + '</li>');
                                $('#level_' + key).addClass("input-border-error");

                                $('#level_' + key).keyup(function(e) {
                                    if ($('#level_' + key).val() != '') {
                                        $('#level_' + key).removeClass(
                                            "input-border-error")
                                    } else {
                                        $('#level_' + key).addClass(
                                            "input-border-error")
                                    }
                                });
                            });
                        } else {
                            $('.spinner1').hide();
                            $('#div-level-modal-error').hide();
                            window.setTimeout(function() {
                                swal("Done!", "The level record saved successfully!",
                                    "success");
                                $('#div-level-modal-error').hide();
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

        });
    </script>
@endsection
