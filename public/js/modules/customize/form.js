$(document).ready(function(){
	 $('.colorPicker').ColorPicker({
	 onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
			
			
			var query = '';
			$('.colorPicker').each(function() {
				if(!$(this).val()) return true;
				
				query += '/' + $(this).attr('name') + '/' + $(this).val();
			});
			
				
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
});