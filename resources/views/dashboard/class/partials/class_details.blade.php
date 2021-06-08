    <div class="row">
        <div class="col-sm-8">
            <ul class="list-icons" style="font-size:95%">
                @if (!empty($courseClass->email_address))
                <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Class Email: <span id="spn_class_email" class="text-primary">{{ $courseClass->email_address }}</span></li>
                @endif
                @if (!empty($courseClass->telephone))
                <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Class Phone#: <span id="spn_class_phone" class="text-primary">{{ $courseClass->telephone }}</span></li>
                @endif
                <!-- <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Lecture Period: <span class="text-info">Mon, Wed, Fri (3PM to 4PM)</span></li> -->
                @if (!empty($courseClass->next_lecture_date))
                <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Next Lecture: <span id="spn_next_lecture_date" class="text-warning">{{ $courseClass->next_lecture_date}}</span></li>
                @endif
                @if (!empty($courseClass->next_exam_date))
                <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Next Exam Date: <span id="spn_next_exam_date" class="text-warning">{{ $courseClass->next_exam_date}}</span></li>
                @endif
                <!-- <li class="ml-10"><i class="text-primary fa fa-certificate mr-5"></i> Assignment #1 is due Monday, 12-Jun-21 </span></li> -->
            </ul>
            @if ($current_user->lecturer_id!=null)
            <a id="btn-show-modify-class-detail-modal" class="text-info" style="font-size:70%" href="#">
                <i class="text-info fa fa-edit ml-10 mr-5"></i>Edit Class Details
            </a>
            @endif
            <br/>
            <br/>
            <h6>Class Dates</h6>
            <ul class="list-icons" style="font-size:95%">
            @if (($courseClass) && count($courseClass->calendarEntries)>0)
            @foreach($courseClass->calendarEntries as $calendarEntry)
                <li class="ml-10"><i class="text-primary fa fa-check mr-5"></i> 
                    <span id="spn_dt_{{$calendarEntry->id}}_date">{{$calendarEntry->due_date->format('d-M-Y')}}</span> - <span id="spn_dt_{{$calendarEntry->id}}_title">{{$calendarEntry->title}}</span> 
                    @if ($current_user->lecturer_id!=null)
                    <a href="#" data-val="{{$calendarEntry->id}}" class="btn-edit-modify-date-modal"><i class="text-info fa fa-pencil ml-5" style="font-size:80%;opacity:0.5;"></i></a> 
                    <a href="#" data-val="{{$calendarEntry->id}}" class="btn-delete-date-entry"><i class="text-info fa fa-times ml-5 mr-5" style="font-size:80%;opacity:0.5;"></i></a>
                    @endif
                </li>
            @endforeach
            @else
                <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> None Added</li>
            @endif
            </ul>
            @if ($current_user->lecturer_id!=null)
            <a id="btn-show-modify-date-modal" class="text-info" style="font-size:70%" href="#">
                <i class="text-info fa fa-edit ml-10 mr-5"></i>Add New Date
            </a>
            @endif
            <br/>
            <br/>

            <h6>Reading Materials</h6>
            <ul class="list-icons" style="font-size:95%">
            @if ($reading_materials!=null && count($reading_materials)>0)
            @foreach($reading_materials as $item)
                @if ($item->course_class_id == $courseClass->id )

                    <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> 
                        <span id="spn_rm_{{$item->id}}_title">{{$item->title}}</span>
                        @if ($current_user->lecturer_id!=null)
                        <a href="#" data-val="{{$item->id}}" class="btn-edit-modify-reading-material-modal"><i class="text-info fa fa-pencil ml-5" style="font-size:80%;opacity:0.5;"></i></a> 
                        <a href="#" data-val="{{$item->id}}" class="btn-delete-reading-material"><i class="text-info fa fa-times ml-5 mr-5" style="font-size:80%;opacity:0.5;"></i></a>
                        @endif 
                        <span id="spn_rm_{{$item->id}}_desc">{{nl2br($item->description)}}</span>
                        @if (!empty($item->reference_material_url))
                        <br/>
                        <a href="{{ $item->reference_material_url }}" style="font-size:85%" class="ml-15 text-primary" target="_blank">
                            <i class="zmdi zmdi-square-right mr-5" class="text-primary"></i><span id="spn_rm_{{$item->id}}_url">{{ $item->reference_material_url }}</span>
                        </a>
                        @endif
                        @if (!empty($item->upload_file_path))
                        <br/>
                        <a href="{{ asset($item->upload_file_path) }}" style="font-size:85%" class="text-primary" target="_blank">
                            <i class="fa fa-download mr-5" class="text-primary"></i>Download
                        </a>
                        @endif
                        <br/>
                    </li>


                @endif
                
            @endforeach
            @else
                <li class="ml-10"><i class="text-primary fa fa-angle-double-right mr-5"></i> None Uploaded</li>
            @endif
            </ul>
            @if ($current_user->lecturer_id!=null)
            <a id="btn-show-modify-reading-material-modal" class="text-info" style="font-size:70%" href="#">
                <i class="text-info fa fa-edit ml-10 mr-5"></i>Add New Reading Material
            </a>
            @endif
            </br>

        </div>
        <div class="col-sm-4">
            <h6>Announcements
            @if ($current_user->lecturer_id!=null)
            <a id="btn-show-modify-announcement-modal" class="pull-right text-info" style="font-size:70%" href="#">
                <i class="text-info fa fa-edit ml-10 mr-5"></i>New
            </a>
            @endif
            </h6>
            <hr class="light-grey-hr mb-5"/>
            @if ( ($courseClass) && $courseClass->announcements!=null && count($courseClass->announcements)>0)
            @foreach($courseClass->announcements as $item)
                @if ($item->course_class_id == $courseClass->id )

                    <dl>
                        <dt class="mb-0"><i class="text-primary fa fa-bullhorn mr-5"></i><span id="spn_announcement_{{$item->id}}_title">{{ $item->title }}</span>
                        @if ($current_user->lecturer_id!=null)
                            <a href="#" data-val="{{$item->id}}" class="btn-edit-modify-announcement-modal"><i class="text-info fa fa-pencil ml-5" style="font-size:80%;opacity:0.5;"></i></a> 
                            <a href="#" data-val="{{$item->id}}" class="btn-delete-announcement"><i class="text-info fa fa-times ml-5 mr-5" style="font-size:80%;opacity:0.5;"></i></a>
                        @endif
                        </dt>
                        <dd class="mb-0" style="font-size:85%;"><span id="spn_announcement_{{$item->id}}_desc">{{ $item->description }}</span></dd>
                    </dl>
                    <p class="text-primary" style="font-size:80%;">
                        Posted on {{ $item->created_at->format('d-M-Y') }}
                    </p>
                    <hr class="light-grey-hr mb-10"/>

                @endif
                
            @endforeach
            @else
                <p style="font-size:95%;" class="muted">No Announcements</p>
            @endif
        </div>
    </div>