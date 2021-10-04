
    <div class="panel panel-default card-view panel-refresh">
        <div class="refresh-container">
            <div class="la-anim-1"></div>
        </div>
        <div class="panel-heading" style="padding: 10px 15px;">
            <div class="pull-left">
                <h4 class="panel-title txt-dark">General Announcements</h4>
            </div>
            <div class="pull-right">
                <a href="{{ route('announcements.index') }}" class="pull-left inline-block mr-15">
                    <i class="zmdi zmdi-surround-sound" style="font-size:inherit;"></i> Manage
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="panel-body" style="padding:0px;">

            <div class="table-wrap sm-data-box-2">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @if (isset($announcements) && count($announcements)>0)
                            @foreach($announcements as $item)
                            <tr>
                                <td class="text-left">
                                    {{$item->title}} {{$item->description}}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-left">
                                    <p>No Genaral Announcements</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
