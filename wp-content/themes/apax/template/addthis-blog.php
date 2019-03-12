<div class="social social-blog">
	<a class="addthis_button_linkedin" title="<?php _e("Share on Linkedin","apax"); ?>"><img src="<?= get_template_directory_uri() ?>/img/social/linkedin-squared.svg" alt="LinkedIn"></a>
	<a class="addthis_button_twitter" title="<?php _e("Share on Twitter","apax"); ?>"><img src="<?= get_template_directory_uri() ?>/img/social/twitter-squared.svg" alt="Twitter"></a>
</div>
<?php $associes = get_field('associes_blog'); ?>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<script type="text/javascript">
var addthis_share = addthis_share || {}
addthis_share = {
	passthrough : {
		twitter: {
			via: "ApaxPartners_FR",
			text: "<?php echo get_the_title().($associes ? ' - '.$associes->post_title : ''); ?>"
		}
	}
}
</script>