

<div class="modal fade" id="capture-photo-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-announcement-title" class="modal-title">Lecture attendance</h4>
            </div>

            <div class="modal-body">
                <div class="capture-error hide-cont" role="alert">
                    Unable to capture image. Please pick a brighter spot to continue.<br><br>
                </div>
                <div class="capture-area">
                    <div id="camera"></div>
                    <div id="snapShotArea"></div>
                    <button type="button" class="btn btn-xs btn-primary" id="capture-btn" value="add">Capture</button>
                </div>
                <input type="hidden" name="join_url">
                <input type="hidden" name="save_url">
            </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-announcement" value="add">Save</button>
            </div> --}}

        </div>
    </div>
</div>

    @section('js-135')
    <script>
        let tries = 0;

        $(document).on('click', '.join-lecture-btn', function(e) { 
            e.preventDefault();
            $(this).text('Checking Webcam...');
            $('.capture-error').fadeOut(300);
            let join_url = $("input[name='join_url']").val($(this).attr('href'));
            $("input[name='save_url']").val($(this).data('save-details'));

            navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
            navigator.getMedia({video: true}, function() {
              //Webcam is available
              $('#capture-photo-modal').modal('show');
            }, function() {
               //Webcam is not available
               $('#capture-photo-modal').modal('hide');
               allowJoinMeeting(join_url);
            });

            // CAMERA SETTINGS.
            Webcam.set({
                width: 420,
                height: 320,
                image_format: 'jpeg',
                jpeg_quality: 100
            });
          
            Webcam.attach('#camera');
            // $('#snapShot').fadeIn(300);
        });

        $(document).on('click', '#capture-btn', function(e) {
            e.preventDefault();
            $(this).text('Capturing...');
            $('.capture-error').fadeOut(300);
            captureImage();
        })

        function captureImage() {
            Webcam.snap(function (data_uri) {
                detectFace(data_uri);
            });
        }

        async function detectFace(data_uri){
            
            const image = new Image();
            image.src= data_uri;
            await faceapi.nets.tinyFaceDetector.loadFromUri('/face-models-service');
           
            
            //const landmarks = await faceapi.detectAllFaces(image, new faceapi.TinyFaceDetectorOptions()).withLandmarks();
            const faces = await faceapi.detectAllFaces(image, new faceapi.TinyFaceDetectorOptions());
                
                // console.log(faces);

            if (faces.length === 0) {
               console.log("no face detected");
               $('#capture-btn').text('Capture');
               $('.capture-error').fadeIn(300);
            }
            if(faces.length > 1){
                console.log("multiple faces detected");
                $('#capture-btn').text('Capture');
                $('.capture-error').fadeIn(300);
            }
            if (faces.length === 1){
                if(faces[0]._score < 0.7){
                    console.log("image quality is low");
                    sendPicture(data_uri);
                }
                if(faces[0]._score > 0.7){
                    console.log("image quality is good ");

                    sendPicture(data_uri);
                }
                console.log("face detected"); 
            }
        }

        function sendPicture(data_uri, join_url) {
            // console.log(data_uri);
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            let actionType = "POST";
            let endPointUrl = $("input[name='save_url']").val();;
            join_url = $("input[name='join_url']").val();

            let formData = new FormData();
            formData.append('student_img', data_uri);
            document.getElementById('snapShotArea').innerHTML = 
            '<br><img src="' + data_uri + '" width="70px" height="50px" />';
            $.ajax({
                url:endPointUrl,
                type: "POST",
                data: formData, 
                cache: false,
                processData:false, 
                contentType: false,
                dataType: 'json',
                success: function(result){
                    $('#capture-btn').text('Redirecting...');
                    window.open(join_url, "_blank");
                },
            });
        } 

        function allowJoinMeeting(join_url) {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            let actionType = "POST";
            let endPointUrl = $("input[name='save_url']").val();
            join_url = $("input[name='join_url']").val();

            let formData = new FormData();
            formData.append('photo_file_path', "NULL");
            $.ajax({
                url:endPointUrl,
                type: "POST",
                data: formData, 
                cache: false,
                processData:false, 
                contentType: false,
                dataType: 'json',
                success: function(result){
                    $('.join-lecture-btn').text('Redirecting...');
                    window.open(join_url, "_blank");
                },
            });
        }
    </script>
    @endsection
