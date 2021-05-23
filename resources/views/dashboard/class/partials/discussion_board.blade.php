    @if ($current_user->lecturer_id!=null)
    <a href="#" id="btn-show-new-discussion-modal" class="btn btn-xs btn-primary">
        <i class="fa fa-upload" style=""></i> New Discussion Board
    </a>
    <br/>
    @endif

    <table class="table table-hover mb-0">
        @foreach($forums as $idx=>$forum)
        <tr>
            <td width="80px">
                <i class="fa fa-5x fa-comments"></i>
            </td>
            <td>
                <span id="spn_forum_{{$forum->id}}_title">{{ $forum->group_name }}</span> <br/>
                <span style="font-size:80%" class="text-success">{{ $forum->posting }}</span>
            </td>
            <td width="80px">
                <a href="#" id="btn-show-board-{{$forum->id}}" class="btn btn-xs btn-primary btn-show-view-forum-modal" data-val="{{$forum->id}}">
                    <i class="fa fa-eye" style=""></i> View
                </a>
            </td>
        </tr>
        @endforeach
    </table>
    <hr class="light-grey-hr mb-10 mt-0"/>