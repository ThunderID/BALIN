{!! HTML::style('Balin/admin/plugin/summernote/summernote.css') !!}
{!! HTML::style('Balin/admin/plugin/summernote/summernote-bs3.css') !!}
{!! HTML::script('Balin/admin/plugin/summernote/summernote.min.js') !!}

<script>
	$(document).ready(function(){
		$('.summernote').summernote({
			height: 250,
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['misc', ['codeview']]
			]
		});
	});
</script>