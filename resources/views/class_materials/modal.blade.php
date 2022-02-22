

<div class="modal fade" id="mdl-classMaterial-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-classMaterial-modal-title" class="modal-title">Class Material</h4>
            </div>

            <div class="modal-body">
                <div id="div-classMaterial-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-classMaterial-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-classMaterial-primary-id" value="0" />
                            <div id="div-show-txt-classMaterial-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('class_materials.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-classMaterial-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('class_materials.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-classMaterial-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-classMaterial-modal", function(e) {
        $('#div-classMaterial-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-classMaterial-modal').modal('show');
        $('#frm-classMaterial-modal').trigger("reset");
        $('#txt-classMaterial-primary-id').val(0);

        $('#div-show-txt-classMaterial-primary-id').hide();
        $('#div-edit-txt-classMaterial-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-classMaterial-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-classMaterial-primary-id').show();
        $('#div-edit-txt-classMaterial-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/class_materials/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/class_materials/"+itemId).done(function( response ) {
			$('#div-classMaterial-modal-error').hide();
			$('#mdl-classMaterial-modal').modal('show');
			$('#frm-classMaterial-modal').trigger("reset");
			$('#txt-classMaterial-primary-id').val(response.data.id);

            // $('#spn_classMaterial_').html(response.data.);
            // $('#spn_classMaterial_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-classMaterial-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-classMaterial-primary-id').hide();
        $('#div-edit-txt-classMaterial-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/class_materials/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/class_materials/"+itemId).done(function( response ) {            
			$('#div-classMaterial-modal-error').hide();
			$('#mdl-classMaterial-modal').modal('show');
			$('#frm-classMaterial-modal').trigger("reset");
			$('#txt-classMaterial-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-classMaterial-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this ClassMaterial?",
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
            let endPointUrl = "{{ route('class_materials.destroy',0) }}"+itemId;

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
                        swal("Done!", "The ClassMaterial record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-classMaterial-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/class_materials/create";
        let endPointUrl = "{{ route('class_materials.store') }}";
        let primaryId = $('#txt-classMaterial-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/class_materials/"+itemId;
            endPointUrl = "{{ route('class_materials.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        // formData.append('', $('#').val());
        // formData.append('', $('#').val());

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
					$('#div-classMaterial-modal-error').html('');
					$('#div-classMaterial-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-classMaterial-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");
                    });
                }else{
                    $('#div-classMaterial-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The ClassMaterial record saved successfully!", "success");
						$('#div-classMaterial-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                console.log(data);
            }
        });
    });

});
</script>
@endsection
