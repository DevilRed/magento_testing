<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->
<head>
	<title><?php if ( is_category() ) {
		echo __('Category Archive for &quot;', HS_CURRENT_THEME); single_cat_title(); echo __('&quot; | ', HS_CURRENT_THEME); bloginfo( 'name' );
	} elseif ( is_tag() ) {
		echo __('Tag Archive for &quot;', HS_CURRENT_THEME); single_tag_title(); echo __('&quot; | ', HS_CURRENT_THEME); bloginfo( 'name' );
	} elseif ( is_archive() ) {
		wp_title(''); echo __(' Archive | ', HS_CURRENT_THEME); bloginfo( 'name' );
	} elseif ( is_search() ) {
		echo __('Search for &quot;', HS_CURRENT_THEME).esc_html($s).__('&quot; | ', HS_CURRENT_THEME); bloginfo( 'name' );
	} elseif ( is_home() || is_front_page()) {
		bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
	}  elseif ( is_404() ) {
		echo __('Error 404 Not Found | ', HS_CURRENT_THEME); bloginfo( 'name' );
	} elseif ( is_single() ) {
		wp_title('');
	} else {
		wp_title( ' | ', true, 'right' ); bloginfo( 'name' ); 
	} ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if(of_get_option('favicon') != ''){ ?>
	<link rel="icon" href="<?php echo of_get_option('favicon', "" ); ?>" type="image/x-icon" />
	<?php } else { ?>
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
	<?php } ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans: 400,300' rel='stylesheet' type='text/css'>

	<script type='text/javascript'>
	(function() {
if ("-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
var msViewportStyle = document.createElement("style");
msViewportStyle.appendChild(
document.createTextNode("@-ms-viewport{width:auto!important}")
);
document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
}
})();
</script>
<?php		
wp_head();
?>	
<!--[if IE 8 ]>
<link rel="stylesheet" id="stylesheet-ie8" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/ie8.css" />
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/respond.js"></script>
<![endif]-->
<style>
.top-header{width: 100%; position: relative;}
.top-header .header-black{height: 50px; width: 100%; background: #000; margin: 0 auto; }
.top-header .header-black a{ color: #fff;   font-family: "Open Sans",sans-serif; font-size: 14px; font-weight: 400; line-height: 50px; text-transform: uppercase;}
.top-header .header-black ul{display: block; margin: 0}
.top-header .header-black ul li{display: inline; margin-right: 10px; color: #fff; text-align: right;}
.top-header .header-black ul li.border-right:after{color: #fff; content: "|"; line-height: 50px; margin-left: 10px;}

.top-header .header-white{height: 150px; width: 100%; background: #fff;text-align: center;}
.blog .title-blog-hidden{display: none}
.top-header .header-white ul{display: inline-block; margin: 50px auto 50px; padding: 0; width: 90%; }
.top-header .header-white ul li{display: inline; margin:50px 2%; position: relative;}

.top-header .header-white ul li a{color: #000; font-family: "Open Sans",sans-serif; font-size: 18px; font-weight: 300; line-height: 32px; text-transform: uppercase; display: inline-block; border: 1px solid #fff; padding: 3px 10px}
.top-header .header-white ul li a.img-logo{border:none;}
.top-header .header-white ul li a:hover{border: 1px solid #000;}
.top-header .header-white ul li a.img-logo:hover{border:none;}
.top-header .header-white ul li ul.submenu{position: absolute; width: 130px; text-align: left; left: 15px; visibility: hidden;}
.top-header .header-white ul li ul.submenu li{display: block; margin: 0; line-height: 1.5em}
.top-header .header-white ul li ul.submenu li a{color: #ccc; border: none; font-size: 11px; line-height: 1.5em; padding: 0}
.top-header .header-white ul li:hover ul.submenu{visibility: visible;}
.custom-footer{background: #000; padding: 50px 0; font-family: "Open Sans",sans-serif; text-align: center;}
.custom-footer ul{display: inline-block; text-align: left;}
.custom-footer ul li{display: inline-block; margin: 0 10px}
.custom-footer ul li a{color: #fff; font-size: 18px}
.custom-footer .social-footer{margin-top: 10px}
.custom-footer .social-footer a{margin: 0 10px; display: inline-block;}
.blog .footer .footer-logo, .blog .footer .lowestfooter{display: none}
#back-top i{ display: block;
  margin-bottom: 7px;
    padding: 20px 25px;
  background: #ffffff;
  -webkit-transition: 1s;
  -moz-transition: 1s;
  -o-transition: 1s;
  transition: 1s; border-radius: 50%;
  font-size: 24px;
  font-weight: bold;
  color: #000;
}
  #back-top a{width: auto!important}
  #back-top a:hover i{background: #c62157; color: #fff}
.span-custom-left{float: left; width: 30%; text-align: left;}
.span-custom-right{float: right; width: 70%; text-align: right;}

.mobile-menu-main{display: none; position: relative; clear: both; padding: 30px 0; }
.mobile-menu-main .menu-toggle{margin-left: 30px; font-size: 16px}
.mobile-menu-main .logo-mobile{margin-right: 30px; }
.mobile-menu-main .magic-menu{display:none; background: #fff; position: absolute; z-index: 100; width: 70%; top: 100px; padding: 20px; left: 50%; transform: translateX(-50%);}
.mobile-menu-main .magic-menu ul.inner-mobile{display: block; float: none; margin: 0 auto; text-align: left; padding: 0;   width: 100%;
  overflow: hidden}
.mobile-menu-main .magic-menu ul.inner-mobile li {display: block; margin: 0; border-bottom: 1px solid #eee; text-align: left; padding: none}
.mobile-menu-main .magic-menu ul.inner-mobile li a{font-size: 16px; border: none; display: block; width: 100%; color: #333;}
.mobile-menu-main .magic-menu ul.inner-mobile li a:hover{border: none; color: red}
.mobile-menu-main .magic-menu ul.inner-mobile li ul.submenu{position: relative;color: #333; display: none; margin: 0; line-height: 1.5em}
.mobile-menu-main .magic-menu ul.inner-mobile li:hover ul.submenu{display: block; width: 100%}
.mobile-menu-main .magic-menu ul.inner-mobile li:hover ul.submenu a{color: #333 !important; font-size: 13px !important; line-height: 2.5em}
.mobile-menu-main .magic-menu ul li ul.submenu li{line-height: 2.5em; border-bottom: 0; border-top: 1px solid #eee;}

/* fix styles */
.header-white.container .container ul li a{
	color: #000;
	font-size: 18px;
	font-weight: 300;
}
.header-white.container .container ul li .submenu li a{
	font-weight: 500;
}
.header-white.container .container ul li .submenu li a:hover{
	color: #000;
}

@media screen and (max-width: 1024px){
	.top-header .header-black a{font-size: 11px}
	.desktop-menu{display: none !important}
	.mobile-menu-main{display: block; }
	.header-black{display: block;}
}

@media screen and (max-width: 420px){
	.header-black{display: none}
}
/*equalize styles between store and blog site*/
@media screen and (min-width: 960px){
	#content.right{
		margin-right: 19px;
	}
	.container{
		max-width: 960px;
	}
	.top-header{
		background-color: #fff;
	}

	.top-header .container{
		max-width: 960px;
	}
	.top-header .header-white.container ul{
		width: 960px;
	}
	.top-header .header-white ul li{
		margin: 50px 2.7%;
	}
	.container .row{
		max-width: 960px;
	}
	.container .row .span2{
		width: 16.66%;
	}
	.container .row .span3{
		width: 25%;
	}
	.container .row .span4{
		width: 32.33%;
	}
	.container .row .span8{
		width: 65.66%;
	}
	.container .row .span12{
		width: 100%;
	}
	.span-custom-left ul{
		padding-left: 9px;/
	}
	.top-header .header-white ul.desktop-menu > li:first-child{
		left: -15px;
	}
}
.top-header .header-white ul li{
	position: relative;
}
.top-header .header-white ul li ul.submenu{
	top: 0;
	margin-top: 28px;
}
.top-header .header-white ul li ul.submenu li a{
	font-size: 12px;
	line-height: 18px;
	font-weight: 400;
	color: #b9b9bb;
}

.header-white.container .container ul li a{
	line-height: 36px;
}
.header-black .span-custom-left ul li{
	position: relative;
	margin: 0 5%;
}
.header-black .span-custom-left ul li:after{
	content: "|";
	color: #fff;
	font-weight: 600;
	position: absolute;
	top: 2px;
	right: -16px;
	line-height: 10px;
}
.top-header .header-black ul li.border-right:after{
	font-weight: 600;
}
.header-black .span-custom-left ul li:last-child:after{
	content: "";
}
/*removing last border in nav*/
.header-black .span-custom-right li:last-child:after{
	content: "" !important;
}
/*submenu behavior*/
.header-black .span-custom-right > ul{
	position: relative;
}
.header-black .span-custom-right > ul > li:first-child{
	position: relative;
	top: -50px;
}
.header-black .span-custom-right > ul > li{
	position: relative;
	display: inline-block;
}
.top-header .header-black .span-custom-right > ul > li:hover .custom{
	display: block;
}
.top-header .header-black .custom{
	background-color: #000;
	width: 150px;
	padding-left: 13px;
	position: absolute;
	left: -16px;
	top: 40px;
	display: none;
}
.header-black .custom li{
	position: relative;
	left: -15px;
}

</style>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#menu-toggle").click(function(){
		jQuery(".magic-menu").toggle();
	});
})
	
</script>
</head>

<body <?php body_class(); ?>>
	<div class="top-header">
		<div class="header-black">
			<div class="container">
				<div class="span-custom-left">
					<ul>
						<li><a href="/contacts/">Contact</a></li>
						<li><a href="/blog/">Magazine</a></li>
					</ul>
				</div>
				
				<div class="span-custom-right">
					<ul>
						<li class="border-right" class="how-to"><a href="/how-to-shop/">HOW TO SHOP</a> </li>
						<li class="border-right"><a href="/customer/account/login/">MY ACCOUNT</a>
							<ul class="sub-menu custom">
								<li><a href="/Quotation/Quote/List/">VIEW MY QUOTES</a></li>
							</ul>
						</li>
						<!-- <li><a href="/Quotation/Quote/List">MY QUOTE LIST</a> </li>
						<li><a hfref="/checkout/cart/"><img src="/skin/frontend/ultimo/atp/images/bg-cart-mini.png"></a></li> -->
					</ul>
				</div>
			</div>
		</div>
		<div class="header-white container">
			<div class="container">
				<div class="mobile-menu-main">
					<div class="mobile-menu span-custom-left">
						<i class="fa fa-bars menu-toggle" id="menu-toggle"></i>
					</div>
					<div class="magic-menu">
						<ul class="inner-mobile">
							<li><a href="/designers">DESIGNERS</a></li>
							<li><a href="javascript: void(0)">ROOMS</a>
								<ul class="submenu">
									<li><a href="/sitting-rooms.html">Sitting Rooms</a></li>
									<li><a href="/table-vignettes.html">Table Vignettes</a></li>
								</ul>
							</li>
							<li><a href="/pieces.html">PIECES</a></li>
							<li><a href="javascript: void(0)">FABRICS</a>
								<ul class="submenu">
									<li><a href="/fabric/fabric?type=source">By Source</a></li>
									<li><a href="/fabric/fabric?type=color">By Color</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="span-custom-right">
						<a href="#" class="logo-mobile"><img src="/blog/wp-content/themes/BUZZBLOG-theme/images/logo-header.png"></a>
					</div>
				</div>
				
				<ul class="desktop-menu">
					<li><a href="/designers">DESIGNERS</a>
					</li>
					<li><a href="#">ROOMS</a>
						<ul class="submenu">
                                                        <li><a href="/sitting-rooms.html">Sitting Rooms</a></li>
                                                        <li><a href="/table-vignettes.html">Decor Vignettes</a></li>
                                                </ul>
					</li>
					<li><a href="/" class="img-logo"><img src="/blog/wp-content/themes/BUZZBLOG-theme/images/logo-header.png"></a></li>
					<li><a href="/pieces.html">PIECES</a></li>
					<li><a href="#">FABRICS</a>
						<ul class="submenu">
							<li><a href="/fabric/fabric?type=source">By Source</a></li>
							<li><a href="/fabric/fabric?type=color">By Color</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<?php $hercules_header_position = of_get_option('header_position'); 
	$hercules_holder = '';
	$issticky = '';
			if($hercules_header_position == 'stickyheader') {
			$hercules_header_position = "header";
			$issticky = "main-holdercon";
			}elseif ($hercules_header_position == 'normalheader') {
			$hercules_header_position = "normal_header";
			$hercules_holder = 'margin-top:0px;';
			$issticky = "stickynot";
			}else {
			$hercules_header_position = "header";
            $issticky = "main-holdercon";
			}
		?>
		<div id="<?php echo $issticky; ?>" class="main-holder" style="<?php echo $hercules_holder; ?>">
<header style="display:none"  id="headerfix" class="headerstyler headerphoto <?php echo $hercules_header_position; ?>" style="<?php if (is_admin_bar_showing() && $hercules_header_position == 'header') {echo ("margin-top:32px;");} ?>">
<div class="header-overlay"></div>
<?php if ( of_get_option('g_search_box_id')=='yes') { ?>
<div class="top-panel22 hidden-phone"> 
    <div class="top-panel-button">
	<a class="popup-with-zoom-anim toggle-button md-trigger" href="#small-dialog"><i class="icon-search-2 icon-2x"></i></a>
    </div>
	<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
	<?php get_template_part("static/static-search"); ?>
	</div> 
</div>
<?php } ?>
<?php if ( of_get_option('g_search_box_id')=='') { ?>
<div class="top-panel22 hidden-phone"> 
    <div class="top-panel-button">
	<a class="popup-with-zoom-anim toggle-button md-trigger" href="#small-dialog"><i class="icon-search-2 icon-2x"></i></a>
    </div>
	<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
	<?php get_template_part("static/static-search"); ?>
	</div> 
</div>
<?php } ?>
	<div class="container title-blog-hidden">
		<div class="row-fluid">
			<div class="span12">
				<?php 	
				get_template_part('wrapper/wrapper-header'); ?>
			</div>
		</div>
	</div>

</header>
