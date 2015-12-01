<!-- documentation 
===================
required:
===================
$data
[
	'title' => notification title
	'content' => notification content
]
===================
Trigger notif
===================
copy this code below to show notification

	$('#notif-window').modal('show');
-->


<div id="notif-window" class="modal modal-notif modal-center fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" style="padding-top:0px;">
		<div class="modal-header">
			<div class="row">
				<div class="col-md-12 text-center title">
					<strong style="letter-spacing: 3px;">{{$data['title']}}</strong>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center content">
					{{$data['content']}}
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#notif-window').on('shown.bs.modal', function() {
	    setTimeout(function(){
			$('#notif-window').modal('hide');
	    }, 800);
	})
</script>