@inject('data', 'App\Models\PointLog')
<?php 
		$data = $data::where('id', $id)
							->first(); 

?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.pointlog.update', ['user_id' => $user_id, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.pointlog.store', ['user_id' => $user_id, 'id' => $id]), 'method' => 'POST']) !!}
	@endif
        {!! Form::hidden('id',$data['id']) !!}    
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kostumer
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="user_id">{{$user['name']}}</label>
					{!! Form::hidden('user_id', $user_id, [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
					]) !!}
				</div>  
			</div>                                        
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="amount">Jumlah</label>
					{!! Form::text('amount', $data['amount'], [
								'class'         => 'form-control money', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan jumlah'
					]) !!}					
				</div>
			</div>
		<?php
			$date = Null;
			$time = Null;
			if (isset($data['expired_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['expired_at'])->format('Y-m-d H:i:s');
			}
		?>

			<div class="col-md-6">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Expire</label>
					{!! Form::input('date','date', $date, [
								'class'         		=> 'form-control date-time-format', 
								'tabindex'      		=> '2',
								'placeholder'   		=> 'dd-mm-yyyy hh:mm',
								'data-date'		 		=> '',
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="notes">Catatan</label>
					{!! Form::textarea('notes', $data['notes'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Tuliskan catatan',
								'rows'          => '2',
								'tabindex'      => '3',
								'style'         => 'resize:none;',
					]) !!}
				</div>            
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.show', ['id' => $user_id ]) }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop



@section('script_plugin')
	@include('plugins.input-mask')
@stop