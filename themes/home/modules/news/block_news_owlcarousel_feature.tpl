<!-- BEGIN: main -->
<div class="news-carousel-slider">
<div class="row">
	<div class="big col-xs-12 col-ms-12 col-sm-12 col-md-12">
		<div class="owl-nav-box"></div>		
		<div class="box-carousel owl-carousel">
			<!-- BEGIN: left -->
			<div id="left" class="owl-item">
				<img alt="{LEFT.title}" src="{LEFT.thumb}" />
				<div class="title"><a title="{CAT_TITLE}" href="{CAT_LINK}">{CAT_TITLE}</a></div>						
				<div class="feat-cap">
					<a href="{LEFT.link}" title="{LEFT.title}"><h3 class="post-title">{LEFT.title_clean}</h3></a>
					<div class="metainfo">
						<!-- BEGIN: author -->	
						<span><i class="fa fa-user"></i> {author}</span>
						<!-- END: author -->
						<span><i class="fa fa-calendar"></i> {LEFT.publtime}</span>
						<span><i class="fa fa-eye"></i> {LEFT.hitstotal}</span>
					</div>	
				</div>
			</div>
			<!-- END: left -->
		</div>
	</div>
	<div id="right" class="col-xs-12 col-sm-12 col-md-12">
		<!-- BEGIN: right -->
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="right-section">
				<!-- BEGIN: img -->
				<a href="{RIGHT.link}" title="{RIGHT.title}"><img alt="{RIGHT.title}" src="{RIGHT.thumb}" /></a>
				<!-- END: img -->
				<div class="feat-cap"><a href="{RIGHT.link}" title="{RIGHT.title}">{RIGHT.title_clean}</a></div>
			</div>
		</div>
		<!-- END: right -->	
	</div>
</div>
<link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/news_owlcarousel_feature.css" rel="stylesheet" type="text/css"/>
<link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
<link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/animate.css" rel="stylesheet" type="text/css"/>
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/owl.carousel.min.js"></script>
<script>
$('.box-carousel').owlCarousel({
	animateIn: '{ANIMATEIN}',
	animateOut: '{ANIMATEOUT}',
	nav: true,
	navText: [ '', '' ],
	navContainer: '.owl-nav-box',
	navClass: [ 'owl-prev-box', 'owl-next-box' ],	
	loop:true,
	margin:10,
	dots: false,	
	autoplay: false,
	items: 1
});	
</script>
<!-- END: main -->