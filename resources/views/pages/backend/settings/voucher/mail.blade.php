@extends('template.backend.layout') 

@section('content')
		{!! Form::open(['url' => route('backend.settings.voucher.postmail', $id), 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="sub-header">
                    Data Mail
                </h4>
            </div>
        </div> 
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="type" class="text-capitalize">Untuk</label>
						{!! Form::text('customer', null, [
									'class' 	=> 'select-customer',
									'style'		=> 'width:100%',
									'tabindex'	=> 1
						]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="description">Isi Mail</label>
					{!! Form::textarea('description', null, 
					[
								'class'         => 'summernote form-control', 
								'rows'          => '2',
								'tabindex'      => '2',
								'style'         => 'resize:none;',
					]) !!}
				</div>            
			</div>
		</div>
		</br>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.voucher.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Kirim</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('script')
    var preload_data_tag    = [];
	var preload_data = [];
@stop

@section('script_plugin')

	@include('plugins.select2')
	@include('plugins.summernote')
@stop
