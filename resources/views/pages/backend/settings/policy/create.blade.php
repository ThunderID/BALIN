@extends('template.backend.layout') 
@inject('datas', 'App\Models\StoreSetting')

<?php 
$datas 		= $datas::policies()->get(); 
$polvals 	= ['expired_cart' => ' + 1 day', 'expired_paid' => ' - 2 days', 'expired_shipped' => '+ 5 days', 'expired_point' => '+ 1 year', 'referral_royalty' => '10000', 'invitation_royalty' =>'50000', 'limit_unique_number' =>'100', 'expired_link_duration' => '+ 2 hours', 'first_quota' => '10', 'downline_purchase_bonus' => '10000', 'downline_purchase_bonus_expired' => ' + 3 months', 'downline_purchase_quota_bonus' => '1', 'voucher_point_expired' => '+ 3 months', 'welcome_gift' => '10000', 'critical_stock' => '2', 'min_margin' => '50000'];
?>

@section('content')
	{!! Form::open(array('url' => route('backend.settings.policies.store'), 'method' => 'POST')) !!}
		<div class="row">
			@foreach($datas as $key => $value)
				{!! Form::hidden('id['.$key.']', $value['id']) !!}			
				<div class="col-md-6">
					<div class="form-group">
						<label for="parent" class="text-capitalize">{{str_replace('_', ' ', $value['type'])}} @if(isset($polvals[$value['type']])) <small><i>ex: {{$polvals[$value['type']]}}</i></small> @endif</label>
						{!! Form::text('value['.$key.']', $value['value'], [
									'class'			=> 'form-control', 
									'tabindex'		=> $key+1
						]) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="parent" class="text-capitalize">Mulai Tanggal</label>
						{!! Form::hidden('type['.$key.']', $value['type'], [
									'class'			=> 'form-control'
						]) !!}
						@if($value)
							<?php $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value['started_at'])->format('d-m-Y H:i'); ?>
						@endif
						{!! Form::text('start['.$key.']', $date, [
									'class'			=> 'date-time-format form-control' 
						]) !!}
					</div>
				</div>
			@endforeach
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.policies.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.summernote')
@stop