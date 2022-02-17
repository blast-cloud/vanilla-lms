

<div class="modal fade" id="mdl-faq-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-faq-modal-title" class="modal-title" style="text-transform: uppercase;">FAQs and Help</h4>
            </div>

            <div class="modal-body">
                <div id="div-faq-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-faq-modal" role="form" method="POST" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div id="spinner1" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-faq-primary-id" value="0" />
                            <div id="div-show-txt-faq-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('faqs.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-faq-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('faqs.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-faq-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-faq-modal", function(e) {
        $('#spinner1').hide();
        $('#div-faq-modal-error').hide();
        $('#mdl-faq-modal').modal('show');
        $('#frm-faq-modal').trigger("reset");
        $('#txt-faq-primary-id').val(0);

        $('#div-show-txt-faq-primary-id').hide();
        $('#div-edit-txt-faq-primary-id').show();
        $('.modal-footer').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-faq-modal", function(e) {
        e.preventDefault();
        $('#spinner1').hide();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-faq-primary-id').show();
        $('#div-edit-txt-faq-primary-id').hide();
        $('.modal-footer').hide('show');
        let itemId = $(this).attr('data-val');
       //alert(itemId)

        // $.get( "{{URL::to('/')}}/api/faqs/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/faqs/"+itemId).done(function( response ) {
			$('#div-faq-modal-error').hide();
			$('#mdl-faq-modal').modal('show');
			$('#frm-faq-modal').trigger("reset");
			$('#txt-faq-primary-id').val(response.data.id);

            $('#lbl-faq-modal-title').html(response.data.type);
            $('#div_faq_type').css('display', 'none');
            $('#spn_faq_question').html(response.data.question);   
            $('#spn_faq_answer').html(response.data.answer);

            let is_visible = 'No';
            if (response.data.is_visible) {
                is_visible = 'Yes';
            }
            $('#spn_faq_visible').html(is_visible);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-faq-modal", function(e) {
        e.preventDefault();
        $('#spinner1').hide();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-faq-primary-id').hide();
        $('#div-edit-txt-faq-primary-id').show();
        let itemId = $(this).attr('data-val');
        let endPointUrl = "{{ route('api.faqs.show','') }}/"+itemId;
        console.log(endPointUrl);
        $.ajax({
            url:endPointUrl,
            type: "get",
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                console.log(result)
               
            }, error: function(data){
                // console.log(result.errors);
                console.log(data)
            }
        });

        // $.get( "{{URL::to('/')}}/api/faqs/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/faqs/"+itemId).done(function( response ) {  
            console.log(response.data);          
			$('#div-faq-modal-error').hide();
			$('#mdl-faq-modal').modal('show');
			$('#frm-faq-modal').trigger("reset");
            $('.modal-footer').show();
			$('#txt-faq-primary-id').val(response.data.id);

            $('#type').val(response.data.type);
            $('#question').val(response.data.question);
            $('#answer').val(response.data.answer);
            if (response.data.is_visible) {
                $('input[name="is_visible"]').prop( "checked", true );
            }
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-faq-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this FAQ?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal({
                title: 'Please Wait !',
                content: wrapper, 
                buttons: false,
                closeOnClickOutside: false
            });
            let endPointUrl = "{{ route('faqs.destroy',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', 'DELETE');
            
            $.ajax({
                url:endPointUrl,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        console.log(result.errors)
                    }else{
                        swal("Done!", "The FAQ record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-faq-modal').click(function(e) {
        e.preventDefault();
        $('#spinner1').show();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        {{-- // let endPointUrl = "{{URL::to('/')}}/api/faqs/create"; --}}
        let endPointUrl = "{{ route('faqs.store') }}";
        let primaryId = $('#txt-faq-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId > 0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/faqs/"+itemId;
            endPointUrl = "{{ route('faqs.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        is_visible = 0;

        if ($('input[name="is_visible"]').is(':checked')) {
            is_visible = 1;
        }

        formData.append('_method', actionType);
        formData.append('question', $('#question').val());
        formData.append('answer',  $('#answer').val());
        formData.append('type',    $('#type').find(':selected').val());
        formData.append('is_visible', is_visible);

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                $('#spinner1').css('display', 'none');
                if(result.errors){
					$('#div-faq-modal-error').html('');
					$('#div-faq-modal-error').show();
                    $.each(result.errors, function(key, value){
                        $('#div-faq-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-faq-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The FAQ record saved successfully!", "success");
						$('#div-faq-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                // console.log(result.errors);
                $('#spinner1').css('display', 'none');
            }
        });
    });

});
</script>
@endsection
