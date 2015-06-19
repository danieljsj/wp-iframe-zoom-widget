var scaleAllScaleBoxes = function(){

	jQuery('.scaleBox').each(function(){

		var boxContentWidth = jQuery(this).attr('data-content-width');
		var boxContentHeightAtBoxContentWidth = jQuery(this).attr('data-content-height-at-content-width');

		var wrapperWidth = jQuery(this).parent().width(); 
		
		var boxScale = wrapperWidth / boxContentWidth;
		var boxWidthStr = (1/boxScale) * 100 + "%";

		jQuery(this)
			
			.css('-ms-zoom', boxScale)
			.css('-moz-transform', 'scale( '+boxScale+' )')
			.css('-moz-transform-origin', '0 0')
			.css('-o-transform', 'scale( '+boxScale+' )')
			.css('-o-transform-origin', '0 0')
			.css('-webkit-transform', 'scale( '+boxScale+' )')
			.css('-webkit-transform-origin', '0 0')

			.css('width', boxWidthStr)
			.css('max-width', boxWidthStr)

			.css('height', /*  boxScale *  */ boxContentHeightAtBoxContentWidth )

			;

	});

};


jQuery(window)
	.resize( 
		scaleAllScaleBoxes 
	);
jQuery(window)
	.load(
		scaleAllScaleBoxes
	);