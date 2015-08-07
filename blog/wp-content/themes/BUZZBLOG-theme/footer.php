</div><!--#main-->	
	
	<div id="back-top-wrapper" class="visible-desktop">
	    <p id="back-top">
	        <a href="#top"><i class="fa fa-angle-up"></i></a>
	    </p>
	</div>
<?php if(of_get_option('ga_code')) { ?>
	<script type="text/javascript">
		<?php echo stripslashes(of_get_option('ga_code')); ?>
	</script>
  <!-- Show Google Analytics -->	
<?php } ?>
<div class="custom-footer">
	<div class="container">
		<div class="span4">
			<a href="/"><img src="/skin/frontend/ultimo/atp/images/logo-footer.png" /></a>
		</div>
		<div class="span5">
			<ul>
				<li><a href="/blog/">MAGAZINE</a></li>
				<li><a href="/about/">ABOUT</a></li>
				<li><a href="/contacts/">CONTACT US</a></li>	
			</ul>
		</div>
		<div class="span3">
			<div class="social-footer">
				<a title="Facebook" href="https://www.facebook.com/atailoredspace" target="_blank">
					<span class="ic ic-img"><img src="/media/wysiwyg/facebook-icon.png" alt="Facebook"></span>
				</a> 
				<a title="Twitter" href="https://twitter.com/atailoredspace" target="_blank">
					<span class="ic ic-img"><img src="/media/wysiwyg/twitter-icon.png" alt="Twitter"></span>
				</a>
				<a title="Pinterest" href="https://www.pinterest.com/atailoredspace" target="_blank">
					<span class="ic ic-img"><img src="/media/wysiwyg/pinterest-icon.png" alt="Pinterest"></span>
				</a>
				<a title="Instagram" href="https://instagram.com/atailoredspace" target="_blank">
					<span class="ic ic-img"><img src="/media/wysiwyg/instagram-icon.png" alt="Instagram"></span>
				</a>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->
</body>
</html>
