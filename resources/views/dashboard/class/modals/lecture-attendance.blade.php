@foreach($lecture_classes as $item)
<div class="modal fade" id="attendance_{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-announcement-title" class="modal-title">
                    <span class="fa fa-users"></span> Lecture attendance - <span id="att-count">{{ $item->attendance->count() }}</span>
                </h4>
            </div>

            <div class="modal-body scroll" id="att-modal-body">
                @if($item->attendance->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Student name</th>
                            <th scope="col">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->attendance as $attendance)
                        <tr>
                            <td class="student-info">
                                <img src="{{ asset('uploads/'.$attendance->photo_file_path) }}"> {{ $attendance->student->first_name.' '.$attendance->student->last_name }}
                            </td>
                            <td>{{ $attendance->created_at->format('l jS F Y \a\t g:i a') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p style="text-align: center;">No records for lecture attendance</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
