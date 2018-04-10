<!-- Header -->
<{include file='db:wggallery_admin_header.tpl'}>

<link href="<{$wggallery_url}>/assets/galleries/colorbox/<{$colorboxstyle}>/colorbox.css" rel="stylesheet">

<{if $images_nb > 0}>
	<div id="mygallery" >
			<{foreach item=image from=$images}>
				<a href='<{$wggallery_upload_url}>/images/<{$source}>/<{$image.name}>' rel='gallery1'>
					<img alt='<{$image.title}>' src='<{$wggallery_upload_url}>/images/<{$source_preview}>/<{$image.name}>'/>
				</a>
			<{/foreach}>
	</div>
<{/if}> 		

<script>
	$("#mygallery").justifiedGallery({
		rowHeight:<{$rowHeight}>,
		lastRow:'<{$lastRow}>',
		margins:<{$margins}>,
		border:<{$border}>,
		captions:<{$title}>,
		randomize:<{$randomize}>,
		rel:'gallery1'
	}).on('jg.complete', function () {
		$(this).find('a').colorbox({
			slideshow:<{$slideshow}>,
			slideshowSpeed:<{$slideshowSpeed}>,
			slideshowAuto: <{$slideshowAuto}>,
			slideshowStart:'<{$slideshowStart}>',
			slideshowStop: '<{$slideshowStop}>',
			speed:<{$speed}>,
			open:<{$open}>,
			opacity:<{$opacity}>,
			transition: '<{$transition}>',
			current: '<{$colorbox_current}>',
			previous: '<{$colorbox_previous}>',
			next: '<{$colorbox_next}>',
			close: '<{$colorbox_close}>',
			maxWidth: '100%',
			<{if $open}>
				onClosed: function () {
					window.history.go(-1);
				}
			<{/if}>
		});
	});
</script>		

<div class="clear spacer"></div>

<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}> 

<!-- Footer -->
<{include file='db:wggallery_admin_footer.tpl'}>