{!! HTML::style('Balin/admin/plugin/jquery-upload/jquery-upload.css') !!}
{!! HTML::script('Balin/admin/plugin/jquery-upload/jquery-upload.js') !!}

<script>
	$('.gallery-upload').fileupload({
		  dataType: 'json',
		  done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					 $('<p/>').text(file.name).appendTo(document.body);
				});
		  }
	 });
</script>
