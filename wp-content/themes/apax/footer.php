		<footer>
			<div id="content-footer">

				<div class="wrap-container wrap-container-totop">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<a href="#" id="gototop" title="<?php _e("Top of page","apax"); ?>"><?php _e("Top of page","apax"); ?></a>
							</div>
						</div>
					</div>
				</div>

				<div class="wrap-container wrap-container-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-7 hidden-sm hidden-xs">
								<div class="row">
									<div class="col-md-3">
										<?php wp_nav_menu( array(
											'theme_location' => 'footer_col1'
										)); ?>
									</div>
									<div class="col-md-4">
										<?php wp_nav_menu( array(
											'theme_location' => 'footer_col2'
										)); ?>
									</div>
									<div class="col-md-2 large">
										<div class="row">
											<?php wp_nav_menu( array(
												'theme_location' => 'footer_col3'
											)); ?>
										</div>
									</div>
									<div class="col-md-3 large">
										<?php wp_nav_menu( array(
											'theme_location' => 'footer_col4'
										)); ?>
									</div>
								</div>
								<a href="<?php echo get_permalink(get_the_id_wpml(10470)); ?>" id="cookies-notice"><?php echo get_the_title(get_the_id_wpml(10470)) ; ?></a>
								<a href="<?php echo get_permalink(get_the_id_wpml(3916)); ?>" id="legal-mentions"><?php echo get_the_title(get_the_id_wpml(3916)) ; ?></a>
							</div>
							<div class="col-md-3">
								<div class="social">
									<a href="https://www.linkedin.com/company/apax-partners-sas" target="_blank"><img src="<?php bloginfo("template_url"); ?>/img/social/linkedin.svg" alt="LinkedIn" /></a>
									<a href="https://www.youtube.com/channel/UCorWjRX9hoHutKusFIdIIRQ" target="_blank"><img src="<?php bloginfo("template_url"); ?>/img/social/youtube.svg" alt="YouTube" /></a>
									<a href="https://twitter.com/ApaxPartners_FR" target="_blank"><img src="<?php bloginfo("template_url"); ?>/img/social/twitter.svg" alt="Twitter" /></a>
								</div>
								<div class="acces-invest">
									<a href="https://investors-extranet.apax.fr/extranet/" target="_blank"><?php _e("Investors access","apax"); ?></a>
								</div>
							</div>
							<div class="col-md-2">
								<div id="blog_info">
									<a href="<?php echo get_permalink(get_the_id_wpml(7197)); ?>">
										<span><?php _e("Digital Magazine","apax"); ?><br/>
										<img src="<?php bloginfo("template_url"); ?>/img/apax-talks.png" alt="Apax Talks" />
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</footer>

		<div class="nl-popin">
			<img src="<?php bloginfo("template_url"); ?>/img/apax-talk-logo-blanc.png" alt="Apax Talks">
			<h2>NEWSLETTER</h2>


			<p><?php _e("Apax Talks is a digital magazine aimed at company managers. It presents growth levers for SMEs, with a focus on TMT, consumer, healthcare and services sectors.", "apax"); ?></p>

			<div class="mailchimp_forms">
				<?php $show_popin = print_mailchimp_form(); ?>
				<div class="clear"></div>
			</div>
		</div>

		<script>var show_mailchimp_popin = <?php var_export($show_popin); ?>;</script>
		<?php wp_footer(); ?>
	</body>
</html>
