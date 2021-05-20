<!-- Code Field -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="code">Code</label>
    <div class="col-sm-9">
        {!! Form::text('code', null, ['id'=>"code", 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="name">Name</label>
    <div class="col-sm-9">
        {!! Form::text('name', null, ['id'=>"name",'class' => 'form-control']) !!}
    </div>
</div>

<!-- Website Url Field -->
<div id="div-website_url" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="website_url">Website Url</label>
    <div class="col-sm-9">
        {!! Form::text('website_url', null, ['id'=>"website_url",'class' => 'form-control']) !!}
    </div>
</div>

<!-- Email Address Field -->
<div id="div-email_address" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email_address">Email Address</label>
    <div class="col-sm-9">
        {!! Form::email('email_address', null, ['id'=>"email_address",'class' => 'form-control']) !!}
    </div>
</div>

<!-- Contact Phone Field -->
<div id="div-contact_phone" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="contact_phone">Contact Phone</label>
    <div class="col-sm-9">
        {!! Form::text('contact_phone', null, ['id'=>"contact_phone",'class' => 'form-control']) !!}
    </div>
</div>