<!-- Code Field -->
<div id="div_department_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_department_code">
        @if (isset($department->code))
            {!! $department->code !!}
        @endif
        </span>
    </p>
</div>

<!-- Name Field -->
<div id="div_department_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_department_name">
        @if (isset($department->name))
            {!! $department->name !!}
        @endif
        </span>
    </p>
</div>

<!-- Website Url Field -->
<div id="div_department_website_url" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('website_url', 'Website Url:', ['class'=>'control-label']) !!} 
        <span id="spn_department_website_url">
        @if (isset($department->website_url))
            {!! $department->website_url !!}
        @endif
        </span>
    </p>
</div>

<!-- Email Address Field -->
<div id="div_department_email_address" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('email_address', 'Email Address:', ['class'=>'control-label']) !!} 
        <span id="spn_department_email_address">
        @if (isset($department->email_address))
            {!! $department->email_address !!}
        @endif
        </span>
    </p>
</div>

<!-- Contact Phone Field -->
<div id="div_department_contact_phone" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('contact_phone', 'Contact Phone:', ['class'=>'control-label']) !!} 
        <span id="spn_department_contact_phone">
        @if (isset($department->contact_phone))
            {!! $department->contact_phone !!}
        @endif
        </span>
    </p>
</div>

