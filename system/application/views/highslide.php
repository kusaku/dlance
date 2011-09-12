<script type="text/javascript"
	src="<?=base_url()?>templates/js/highslide/highslide-with-gallery.js"></script>
<link
	rel="stylesheet" type="text/css"
	href="<?=base_url()?>templates/js/highslide/highslide.css" />

<script type="text/javascript">
	hs.graphicsDir = '<?=base_url()?>templates/js/highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: false,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
