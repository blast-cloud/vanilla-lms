<!--FAQ Type Field -->
<div id="div_faq_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('type', 'Type:', ['class'=>'control-label']) !!} 
        <span id="spn_faq_type">
        @if (isset($faq->type))
            {!! $faq->type !!}
        @endif
        </span>
    </p>
</div>

<!-- Question Field -->
<div id="div_faq_question" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('question', 'Question:', ['class'=>'control-label']) !!} 
        <span id="spn_faq_question">
        @if (isset($faq->question))
            {!! $faq->question !!}
        @endif
        </span>
    </p>
</div>

<!-- Answer Field -->
<div id="div_faq_answer" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('answer', 'Answer:', ['class'=>'control-label']) !!} 
        <span id="spn_faq_answer">
        @if (isset($faq->answer))
            {!! $faq->answer !!}
        @endif
        </span>
    </p>
</div>

<!-- Visibility Field -->
<div id="div_faq_visible" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('visible', 'Visible:', ['class'=>'control-label']) !!} 
        <span id="spn_faq_visible">
        @if (isset($faq->is_visible))
            {!! $faq->is_visible !!}
        @endif
        </span>
    </p>
</div>

