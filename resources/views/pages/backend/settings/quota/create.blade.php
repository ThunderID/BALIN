@inject('data', 'App\Models\QuotaLog')
<?php 
		$data = $data::id($id)->voucherid($vou_id)->first(); 
?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.settings.quota.update', ['vou_id' => $vou_id, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.settings.quota.store', ['vou_id' => $vou_id, 'id' => $id]), 'method' => 'POST']) !!}
	@endif
        {!! Form::hidden('id',$data['id']) !!}    
        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Voucher @if($voucher['type']=='referral') {{$voucher['type']}} @endif  #{{$voucher['code']}}
                </h4>
            </div>
        </div>
		{!! Form::hidden('voucher_id', $vou_id, ['class'         => 'form-control', ]) !!}
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="amount">Quota</label>
					{!! Form::input('number', 'amount', $data['amount'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan jumlah quota (gunakan (-) untuk pengurangan quota)'
					]) !!}	
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="amount">Catatan</label>
					{!! Form::textarea('notes', $data['notes'], [
								'class'         => 'form-control', 
								'tabindex'      => '2', 
					]) !!}	
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.voucher.show', ['id' => $vou_id ]) }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop

@section('script_plugin')
	@include('plugins.select2')
@stop