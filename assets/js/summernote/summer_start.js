	$(document).ready(function() {
		$('.summernote').summernote({height: 350,
		toolbar: [
		//[groupname, [button list]]

		['style', ['bold', 'italic', 'underline', 'clear']],
		['font', ['strikethrough', 'superscript', 'subscript']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['height', ['height']],
		['insert',['video','table','hr', 'link', 'picture']]
		]
		});	
	});
