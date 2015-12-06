@inject('data', 'App\Models\Voucher')

@if ($id)
	<?php 
		$data = $data::where('id',$id)->first();
	?>
@endif


@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.settings.voucher.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.settings.voucher.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="sub-header">
                    Data Voucher
                </h4>
            </div>
        </div> 
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="code" class="text-capitalize">Kode</label>
					{!! Form::text('code', $data['code'], [
								'class'         => 'form-control', 
								'tabindex'      => '1',
								'placeholder'   => 'Masukkan kode voucher',
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="type" class="text-capitalize">Tipe</label>
					@if(is_null($id))
					{!! Form::select('type', ['promo_referral' => 'Promo Referral', 'free_shipping_cost' => 'Potongan Shipping Cost', 'debit_point' => 'Debit Point'], $data['type'], ['class' => 'form-control', 'tabindex' => '2']) !!}
					@else
					{!! Form::label('type', $data['type'], ['class' => 'form-control', 'tabindex' => '2']) !!}
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="value" class="text-capitalize">Nilai</label>
					{!! Form::text('value', $data['value'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan nilai',
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="start">Mulai</label>
					{!! Form::text('started_at', (!is_null($data['started_at']) ? $data['started_at']->format('d-m-Y h:i') : ''), [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '4', 
								'placeholder'   => 'dd-mm-yyyy hh:mm'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="start">Expire</label>
					{!! Form::text('expired_at', (!is_null($data['expired_at']) ? $data['expired_at']->format('d-m-Y h:i') : ''), [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '5', 
								'placeholder'   => 'dd-mm-yyyy hh:mm'
					]) !!}
				</div>  
			</div> 
		</div> 
		</br>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.voucher.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop