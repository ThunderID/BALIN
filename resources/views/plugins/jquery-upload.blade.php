{!! HTML::style('Balin/admin/plugin/jquery-upload/jquery-upload.css') !!}
{!! HTML::script('Balin/admin/plugin/jquery-upload/jquery-upload.js') !!}

<script>
	$('.btn-file-upload').click( function() {
		$('.file-upload').trigger('click');
	});
	$('.btn-gallery-upload').click( function() {
		$('.gallery-upload').trigger('click');
	});

	$('.gallery-upload').fileupload({
		  dataType: 'json',
		  done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					 $('<p/>').text(file.name).appendTo(document.body);
				});
		  }
	 });
</script>
