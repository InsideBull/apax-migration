<?php
	if(is_front_page())
		get_template_part("page", "home");
	else
		get_template_part("page", "content");
?>