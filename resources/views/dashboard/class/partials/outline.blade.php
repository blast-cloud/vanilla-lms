<hr class="light-grey-hr mb-10 mt-0"/>
@if ($current_user->lecturer_id!=null)
<a id="btn-show-modify-outline-modal" class="pull-right text-info" style="font-size:75%" href="#">
    <i class="text-info fa fa-edit ml-10 mr-5"></i>Modify
</a>
@endif
@if (!empty($courseClass->outline))
<blockquote id="blq_class_outline" style="font-size:95%">
    {!! nl2br($courseClass->outline) !!}
</blockquote>
<span id="spn_class_outline" style="display:none;">{!! $courseClass->outline !!}</span>
@endif