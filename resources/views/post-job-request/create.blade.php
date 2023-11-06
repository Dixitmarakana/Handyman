<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? __('messages.list') }}</h5>
                            <a href="{{ route('service.index') }}" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                            @if($auth_user->can('service list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($servicedata,['method' => 'POST','route'=>'service.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'service'] ) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.name').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name', old('name'), ['placeholder' => __('messages.name'), 'class' => 'form-control', 'title' => 'Please enter alphabetic characters and spaces only']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.category') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('category_id', [optional($servicedata->category)->id => optional($servicedata->category)->name], optional($servicedata->category)->id, [
                                            'class' => 'select2js form-group category',
                                            'required',
                                            'id' => 'category_id',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.category') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                        ]) }}

                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('subcategory_id', __('messages.select_name',[ 'select' => __('messages.subcategory') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('subcategory_id', [], [
                                        'class' => 'select2js form-group subcategory_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.subcategory') ]),
                                    ]) }}
                            </div>

                            @if(auth()->user()->hasAnyRole(['admin','demo_admin']))
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.provider') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('provider_id', [ optional($servicedata->providers)->id => optional($servicedata->providers)->display_name ], optional($servicedata->providers)->id, [
                                            'class' => 'select2js form-group',
                                            'id' => 'provider_id',
                                            'required',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.provider') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'provider']),
                                        ]) }}
                            </div>
                            @endif
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.provider_address') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('provider_address_id[]', [], old('provider_address_id'), [
                                        'class' => 'select2js form-group provider_address_id',
                                        'id' =>'provider_address_id',
                                        'multiple' => 'multiple',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.provider_address') ]),
                                    ]) }}
                                <a href="{{ route('provideraddress.create') }}" class=""><i
                                        class="fa fa-plus-circle mt-2"></i>
                                    {{ trans('messages.add_form_title',['form' => trans('messages.provider_address')  ]) }}</a>
                            </div> 

                            <div class="form-group col-md-4">
                                {{ Form::label('type',__('messages.price_type').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('type',['fixed' => __('messages.fixed') , 'hourly' => __('messages.hourly'), 'free' => __('messages.free') ],old('status'),[ 'class' =>'form-control select2js','required' ,'id'=>'price_type']) }}
                            </div>
                            <div class="form-group col-md-4" id="price_div">
                                {{ Form::label('price',__('messages.price').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::number('price',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('messages.price'),'class' =>'form-control', 'required','id' => 'price' ]) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4" id="discount_div">
                                {{ Form::label('discount',__('messages.discount').' %', ['class' => 'form-control-label']) }}
                                {{ Form::number('discount',null, [ 'min' => 0,'max' => 99, 'step' => 'any' , 'id' =>'discount','placeholder' => __('messages.discount'),'class' =>'form-control']) }}

                                <span id="discount-error" class="text-danger"></span>
                            </div>


                            <div class="form-group col-md-4">
                                {{ Form::label('duration', __('messages.duration').' (hours) <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('duration', old('duration'), ['placeholder' => __('messages.duration'), 'class' => 'form-control min-datetimepicker-time', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('status',__('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'class' =>'form-control select2js','required']) }}
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label" for="service_attachment">{{ __('messages.image') }}
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="service_attachment[]" class="custom-file-input"
                                        data-file-error="{{ __('messages.files_not_allowed') }}" multiple>
                                    <label
                                        class="custom-file-label upload-label">{{ __('messages.choose_file',['file' =>  __('messages.attachments') ]) }}</label>
                                </div>
                            </div>
                        </div>


                        <div class="row service_attachment_div">
                            <div class="col-md-12">


                                @if(getMediaFileExit($servicedata, 'service_attachment'))
                                @php

                                $attchments = $servicedata->getMedia('service_attachment');

                                $file_extention = config('constant.IMAGE_EXTENTIONS');
                                @endphp
                                <div class="border-left-2">
                                    <p class="ml-2"><b>{{ __('messages.attached_files') }}</b></p>
                                    <div class="ml-2 my-3">
                                        <div class="row">
                                            @foreach($attchments as $attchment )
                                            <?php
                                            $extention = in_array(strtolower(imageExtention($attchment->getFullUrl())), $file_extention);
                                            ?>

                                            <div class="col-md-2 pr-10 text-center galary file-gallary-{{$servicedata->id}}"
                                                data-gallery=".file-gallary-{{$servicedata->id}}"
                                                id="service_attachment_preview_{{$attchment->id}}">
                                                @if($extention)
                                                <a id="attachment_files" href="{{ $attchment->getFullUrl() }}"
                                                    class="list-group-item-action attachment-list" target="_blank">
                                                    <img src="{{ $attchment->getFullUrl() }}" class="attachment-image"
                                                        alt="">
                                                </a>
                                                @else
                                                <a id="attachment_files"
                                                    class="video list-group-item-action attachment-list"
                                                    href="{{ $attchment->getFullUrl() }}">
                                                    <img src="{{ asset('images/file.png') }}" class="attachment-file">
                                                </a>
                                                @endif
                                                <a class="text-danger remove-file"
                                                    href="{{ route('remove.file', ['id' => $attchment->id, 'type' => 'service_attachment']) }}"
                                                    data--submit="confirm_form" data--confirmation='true'
                                                    data--ajax="true" data-toggle="tooltip"
                                                    title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-message='{{ __("messages.remove_file_msg") }}'>
                                                    <i class="ri-close-circle-line"></i>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                {{ Form::label('description',__('messages.description'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                            </div>

                            <div class="form-group col-md-6">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('is_featured', $servicedata->is_featured, null, ['class' => 'custom-control-input', 'id' => 'is_featured' ]) }}
                                    <label class="custom-control-label"
                                        for="is_featured">{{ __('messages.set_as_featured') }}</label>
                                </div>
                            </div>
                            @if(!empty( $settingdata) && $settingdata->value == 1)
                            <div class="form-group col-md-6" id="is_enable_advance">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    {{ Form::checkbox('is_enable_advance_payment', $servicedata->is_enable_advance_payment , null, ['class' => 'custom-control-input' , 'id' => 'is_enable_advance_payment' ]) }}
                                    <label class="custom-control-label"
                                        for="is_enable_advance_payment">{{ __('messages.enable_advanced_payment')  }}
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="form-group col-md-4" id="amount">
                                {{ Form::label('advance_payment_amount',__('messages.advance_payment_amount').' <span class="text-danger"></span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::number('advance_payment_amount',old('advance_payment_amount'),['placeholder' => __('messages.amount'),'class' =>'form-control','min' => '1', 'max' => '99']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                        </div>

                        {{ Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('bottom_script')
    @endsection
</x-master-layout>