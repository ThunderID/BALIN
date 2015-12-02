@inject('store', 'App\Models\StoreSetting')

<?php 
	$stores			= $store->type('why_join')->Ondate('now')->first();
	$tc 			= $store->type('term_and_condition')->ondate('now')->orderby('started_at', 'desc')->first();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join">
		<div class="row mt-75 mobile-m-t-25" style="padding-top:20px">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12 hidden-xs">
									 <div class="row">
										<div class="col-md-12">
											{!! $stores['value'] !!}
										</div>
									</div>
									<div class="clearfix">&nbsp;</div>
								</div>
								<div class="col-md-5 col-xs-12 col-md-offset-2">
									<div class="row panel-hollow panel-default p-xs m-t-n-xs">
										<div class="col-md-12">
											<div class="sign-up">
												<h3>Sign Up By Invitation</h3>
												<div class="clearfix">&nbsp;</div>
												@include('widgets.alerts')
												@include('widgets.signup', ['is_invitation' => true])
											</div>
										</div>	
										<div class="clearfix">&nbsp;</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>

		<div id="tnc" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Term & Condition</h4>
					</div>
					<div class="modal-body ribbon-menu">
						<div class="row">
							<div class="col-md-12">
								{!! $tc['value'] !!}
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop