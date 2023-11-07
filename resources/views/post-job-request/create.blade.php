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
                {{ Form::model($postJob,['method' => 'POST','route'=>'postJobRequest.save', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'postJob'] ) }}

                {{ Form::hidden('id') }}
                    <div class="row">
                        <div class="form-group col-md-4">
                            {{ Form::label('job_title', __('messages.job_title').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                            {{ Form::text('job_title', old('job_title'), ['placeholder' => __('messages.job_title'), 'class' => 'form-control', 'title' => 'Please enter alphabetic characters and spaces only','required']) }}
                            <small class="help-block with-errors text-danger"></small>
                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.provider') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            <br />
                            {{ Form::select('provider_id', [optional($postJob->provider)->id => optional($postJob->provider)->name], optional($postJob->provider)->id, [
                                        'class' => 'select2js form-group provider',
                                        'required',
                                        'id' => 'provider_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.provider') ]),
                                        'data-ajax--url' => route('ajax-list', ['type' => 'provider']),
                                    ]) }}

                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.category') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            <br />
                            {{ Form::select('category_id', [optional($postJob->category)->id => optional($postJob->category)->name], optional($postJob->category)->id, [
                                        'class' => 'select2js form-group category',
                                        'required',
                                        'id' => 'category_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.category') ]),
                                        'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                    ]) }}

                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('subcategory_id', __('messages.select_name',[ 'select' => __('messages.subcategory') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            <br />
                            {{ Form::select('subcategory_id', [], [
                                    'class' => 'select2js form-group subcategory_id',
                                    'required',
                                    'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.subcategory') ]),
                                ]) }}
                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('country', __('messages.country').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                            {{ Form::select('country_id', [optional($postJob->country)->id => optional($postJob->country)->name], optional($postJob->category)->id, [
                                'class' => 'select2js form-group category',
                                'required',
                                'id' => 'country_id',
                                'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.country') ]),
                                'data-ajax--url' => route('ajax-list', ['type' => 'country']),
                            ]) }}
                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('state_id', __('messages.select_name',[ 'select' => __('messages.state') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            <br />
                            {{ Form::select('state_id', [], [
                                    'class' => 'select2js form-group state_id',
                                    'required',
                                    'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.state') ]),
                                ]) }}
                        </div>

                        <div class="form-group col-md-4">
                            {{ Form::label('city_id', __('messages.select_name',[ 'select' => __('messages.city') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            <br />
                            {{ Form::select('city_id', [], [
                                    'class' => 'select2js form-group city_id',
                                    'required',
                                    'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.city') ]),
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

                        <div class="form-group col-md-4" id="price_div">
                            {{ Form::label('price',__('messages.price').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            {{ Form::number('price',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('messages.price'),'class' =>'form-control', 'required','id' => 'price' ]) }}
                            <small class="help-block with-errors text-danger"></small>
                        </div>

                        <div class="form-group col-md-4" id="job_price_div">
                            {{ Form::label('job_price',__('messages.job_price').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                            {{ Form::number('job_price',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('messages.job_price'),'class' =>'form-control', 'required','id' => 'job_price' ]) }}
                            <small class="help-block with-errors text-danger"></small>
                        </div>
                            <div class="form-group col-md-12">
                                {{ Form::label('description',__('messages.description'), ['class' => 'form-control-label'])}}
                                {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                            </div>
                    </div>

                    {{ Form::submit(__('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>


@section('bottom_script')
<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            var provider_id = "{{ isset($postJob->provider_id) ? $postJob->provider_id : '' }}";
            var category_id = "{{ isset($postJob->category_id) ? $postJob->category_id : '' }}";
            var subcategory_id = "{{ isset($postJob->subcategory_id) ? $postJob->subcategory_id : '' }}";
            var country_id = "{{ isset($postJob->country_id) ? $postJob->country_id : '' }}";
            var state_id = "{{ isset($postJob->state_id) ? $postJob->state_id : '' }}";
            var city_id = "{{ isset($postJob->city_id) ? $postJob->city_id : '' }}";

            getSubCategory(category_id, subcategory_id)
            getState(country_id, state_id);
            getCity(state_id, city_id);

            $(document).on('change', '#category_id', function() {
                var category_id = $(this).val();
                $('#subcategory_id').empty();
                // console.log(category_id + ' : ' + subcategory_id );
                getSubCategory(category_id, subcategory_id);
            })

            $(document).on('change', '#country_id', function() {
                console.log("country_id");
                var country_id = $(this).val();
                $('#state_id').empty();
                getState(country_id, state_id);
            })

            $(document).on('change', '#state_id', function() {
                var state_id = $(this).val();
                console.log("state_id" , state_id);
                $('#city_id').empty();
                getCity(state_id, city_id);
            })
        })

        function getSubCategory(category_id, subcategory_id = "") {
            console.log('s');
            var get_subcategory_list =
                "{{ route('ajax-list', [ 'type' => 'subcategory_list','category_id' =>'']) }}" + category_id;
            get_subcategory_list = get_subcategory_list.replace('amp;', '');

            $.ajax({
                url: get_subcategory_list,
                success: function(result) {
                    $('#subcategory_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.subcategory')]) }}",
                        data: result.results
                    });
                    if (subcategory_id != "") {
                        $('#subcategory_id').val(subcategory_id).trigger('change');
                    }
                }
            });
        }

        function getState(country_id, state_id = "") {
            if(country_id != ''){
                var get_state_list = "{{ route('ajax-list', [ 'type' => 'state','country_id' =>'']) }}" + country_id;
                get_state_list = get_state_list.replace('amp;', '');
                $.ajax({
                    url: get_state_list,
                    success: function(result) {
                        $('#state_id').select2({
                            width: '100%',
                            placeholder: "{{ trans('messages.select_name',['select' => trans('messages.state')]) }}",
                            data: result.results
                        });
                        if (state_id != "") {
                            $('#state_id').val(state_id).trigger('change');
                        }
                    }
                });
            }
        }

        function getCity(state_id, city_id = "") {
            console.log(state_id);
            if(state_id != ''){
                var get_state_list = "{{ route('ajax-list', [ 'type' => 'city','state_id' =>'']) }}" + state_id;
                get_state_list = get_state_list.replace('amp;', '');
                $.ajax({
                    url: get_state_list,
                    success: function(result) {
                        $('#city_id').select2({
                            width: '100%',
                            placeholder: "{{ trans('messages.select_name',['select' => trans('messages.city')]) }}",
                            data: result.results
                        });
                        if (state_id != "") {
                            $('#city_id').val(state_id).trigger('change');
                        }
                    }
                });
            }
        }
    })(jQuery);
</script>
@endsection
</x-master-layout>
