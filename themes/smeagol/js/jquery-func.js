$( document ).ready( function(){
	$('.blink')
		.focus(function(){
			if( $(this).attr('value') == $(this).attr('title') ) {
				$(this).attr({ 'value': '' });
			}
		})
		.blur(function(){
			if( $(this).attr('value') == '' ) {
				$(this).attr({ 'value': $(this).attr('title') })
			}
		});
});
