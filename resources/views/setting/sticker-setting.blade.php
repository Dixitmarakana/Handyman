{{ Form::open(['method' => 'POST','route' => ['stickerSave'],'enctype'=>'multipart/form-data','data-toggle'=>'validator']) }}
{{ Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control')) }}

{{ Form::hidden('page', $page, array('placeholder' => 'id','class' => 'form-control')) }}

<div class="row">
    <div class="form-group">
        <label for="" class="col-sm-6 form-control-label">{{ __('messages.sticker') }}</label>
        <div class="col-sm-12">
            {{ Form::file('sticker',['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"sticker" , 'lang'=>"en" , 'accept'=>"image/*"]) }}
            <label class="custom-file-label upload-label" for="sticker">{{ __('messages.sticker') }}</label>
        </div>
    </div>
</div>
<div class="row">  
    <div class="form-group">
        <label for="" class="col-sm-6 form-control-label">{{ __('messages.sticker_type') }}</label>
        <div class="col-sm-12">
            {{ Form::text('sticker_type', null, ['class'=>"form-control" , 'placeholder'=> __('messages.sticker_type_placeholder') ]) }}
        </div>
    </div>  
</div>

{{ Form::submit(__('messages.save'), ['class'=>"btn btn-md btn-primary float-md-right"]) }}
{{ Form::close() }}
