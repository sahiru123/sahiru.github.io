<?php 

	$yoga_studio_sticky_header = get_theme_mod('yoga_studio_sticky_header');

	$yoga_studio_custom_style= "";

	if($yoga_studio_sticky_header != true){

		$yoga_studio_custom_style .='.menu_header.fixed{';

			$yoga_studio_custom_style .='position: static;';
			
		$yoga_studio_custom_style .='}';
	}

	$yoga_studio_logo_max_height = get_theme_mod('yoga_studio_logo_max_height');

	if($yoga_studio_logo_max_height != false){

		$yoga_studio_custom_style .='.custom-logo-link img{';

			$yoga_studio_custom_style .='max-height: '.esc_html($yoga_studio_logo_max_height).'px;';
			
		$yoga_studio_custom_style .='}';
	}

	/*---------------------------Width -------------------*/
	
	$yoga_studio_theme_width = get_theme_mod( 'yoga_studio_width_options','full_width');

    if($yoga_studio_theme_width == 'full_width'){

		$yoga_studio_custom_style .='body{';

			$yoga_studio_custom_style .='max-width: 100%;';

		$yoga_studio_custom_style .='}';

	}else if($yoga_studio_theme_width == 'container'){

		$yoga_studio_custom_style .='body{';

			$yoga_studio_custom_style .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';

		$yoga_studio_custom_style .='}';

	}else if($yoga_studio_theme_width == 'container_fluid'){

		$yoga_studio_custom_style .='body{';

			$yoga_studio_custom_style .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';

		$yoga_studio_custom_style .='}';
	}

	/*---------------------------Scroll-top-position -------------------*/
	
	$yoga_studio_scroll_options = get_theme_mod( 'yoga_studio_scroll_options','right_align');

    if($yoga_studio_scroll_options == 'right_align'){

		$yoga_studio_custom_style .='.scroll-top button{';

			$yoga_studio_custom_style .='';

		$yoga_studio_custom_style .='}';

	}else if($yoga_studio_scroll_options == 'center_align'){

		$yoga_studio_custom_style .='.scroll-top button{';

			$yoga_studio_custom_style .='right: 0; left:0; margin: 0 auto; top:85% !important';

		$yoga_studio_custom_style .='}';

	}else if($yoga_studio_scroll_options == 'left_align'){

		$yoga_studio_custom_style .='.scroll-top button{';

			$yoga_studio_custom_style .='right: auto; left:5%; margin: 0 auto';

		$yoga_studio_custom_style .='}';
	}

	//--------------------------------------------------------------------------

	$yoga_studio_logo_max_height = get_theme_mod('yoga_studio_logo_max_height');

	if($yoga_studio_logo_max_height != false){

		$yoga_studio_custom_style .='.custom-logo-link img{';

			$yoga_studio_custom_style .='max-height: '.esc_html($yoga_studio_logo_max_height).'px;';
			
		$yoga_studio_custom_style .='}';
	}