<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title></title>
</head>
<span style="text-align:right"><a href="#" class="btn btn-primary print_attendance" id="print_attendance"><i class="fa fa-print"></i>Print</a></span>
<body>
<h4 id="lecture-attendance" class="" style="text-align:center; font-size:20px; font-family:Arial">
    <span class="fa fa-users" ></span> Lecture attendance - <span id="att-count">{{ count($attendances)}}</span>
</h4>
@if($attendances != null && count($attendances)>0)
<table border="1" align="center" cellpadding="5" class="" style="border-spacing:0;" width="70%">
    <thead>
        <tr>
            <th style="text-align:center;font-size:15px;font-family:Arial">No(#)</th>
            <th style="text-align:center;font-size:15px;font-family:Arial">Student name</th>
            <th style="text-align:center; font-size:15px;font-family:Arial">Joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $key=>$attendance)
        <tr>
            <td style="text-align:center;font-size:15px;font-family:Arial">{{ ++$key }}</td>
            <td style="text-align:center;font-size:15px;font-family:Arial">
                <img src="{{ asset('uploads/'.$attendance->photo_file_path) }}"> {{ $attendance->student->first_name.' '.$attendance->student->last_name }}
            </td>
            <td style="text-align:center;font-size:15px;font-family:Arial">{{ $attendance->created_at->format('l jS F Y \a\t g:i a') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p style="text-align:center;font-size:15px;font-family:Arial">No records for lecture attendance</p>
@endif
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('a.print_attendance').click((e) => {
        e.preventDefault();
        window.print();
        return false;
    });
});
</script>
</body>
</html>

