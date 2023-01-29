@php
$current_user = Auth()->user();
@endphp
<!-- Title Field -->
<div id="div_announcement_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_title">
        @if (isset($announcement->title))
            {!! $announcement->title !!}
        @endif
        </span>
    </p>
</div>
@if($current_user->is_platform_admin == true || $current_user->manager_id != null)
<div id="div_announcement_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('announcement_end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_end_date">
        @if (isset($announcement->announcement_end_date))
           {!! date('d-m-Y', strtotime($announcement->announcement_end_date)) !!}
        @endif
        </span>
    </p>
</div>
@endif

<!-- Description Field -->
<div id="div_announcement_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_description">
        @if (isset($announcement->description))
            {!! $announcement->description !!}
        @endif
        </span>
    </p>
</div>

