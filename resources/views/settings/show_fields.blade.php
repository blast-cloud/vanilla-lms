<!-- Key Field -->
<div id="div_setting_key" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('key', 'Key:', ['class'=>'control-label']) !!} 
        <span id="spn_setting_key">
        @if (isset($setting->key))
            {!! $setting->key !!}
        @endif
        </span>
    </p>
</div>

<!-- Value Field -->
<div id="div_setting_value" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('value', 'Value:', ['class'=>'control-label']) !!} 
        <span id="spn_setting_value">
        @if (isset($setting->value))
            {!! $setting->value !!}
        @endif
        </span>
    </p>
</div>

<!-- Group Name Field -->
<div id="div_setting_group_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('group_name', 'Group Name:', ['class'=>'control-label']) !!} 
        <span id="spn_setting_group_name">
        @if (isset($setting->group_name))
            {!! $setting->group_name !!}
        @endif
        </span>
    </p>
</div>

<!-- Model Type Field -->
<div id="div_setting_model_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('model_type', 'Model Type:', ['class'=>'control-label']) !!} 
        <span id="spn_setting_model_type">
        @if (isset($setting->model_type))
            {!! $setting->model_type !!}
        @endif
        </span>
    </p>
</div>

<!-- Model Value Field -->
<div id="div_setting_model_value" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('model_value', 'Model Value:', ['class'=>'control-label']) !!} 
        <span id="spn_setting_model_value">
        @if (isset($setting->model_value))
            {!! $setting->model_value !!}
        @endif
        </span>
    </p>
</div>

