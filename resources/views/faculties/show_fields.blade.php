<!-- Code Field -->
<div id="div_faculty_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_faculty_code">
        @if (isset($faculty->code))
            {!! $faculty->code !!}
        @endif
        </span>
    </p>
</div>

<!-- Name Field -->
<div id="div_faculty_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_faculty_name">
        @if (isset($faculty->name))
            {!! $faculty->name !!}
        @endif
        </span>
    </p>
</div>

<!-- Website Url Field -->
<div id="div_faculty_website_url" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('website_url', 'Website Url:', ['class'=>'control-label']) !!} 
        <span id="spn_faculty_website_url">
        @if (isset($faculty->website_url))
            {!! $faculty->website_url !!}
        @endif
        </span>
    </p>
</div>

<!-- Email Address Field -->
<div id="div_faculty_email_address" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('email_address', 'Email Address:', ['class'=>'control-label']) !!} 
        <span id="spn_faculty_email_address">
        @if (isset($faculty->email_address))
            {!! $faculty->email_address !!}
        @endif
        </span>
    </p>
</div>

<!-- Contact Phone Field -->
<div id="div_faculty_contact_phone" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('contact_phone', 'Contact Phone:', ['class'=>'control-label']) !!} 
        <span id="spn_faculty_contact_phone">
        @if (isset($faculty->contact_phone))
            {!! $faculty->contact_phone !!}
        @endif
        </span>
    </p>
</div>

