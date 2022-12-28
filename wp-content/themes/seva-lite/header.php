<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Seva_Lite
 */
    /**
     * Doctype Hook
     * 
     * @hooked seva_lite_doctype
    */
    do_action( 'seva_lite_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked seva_lite_head
    */
    do_action( 'seva_lite_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php
    wp_body_open();
    
    /**
     * Before Header
     * 
     * @hooked seva_lite_page_start - 20 
    */
    do_action( 'seva_lite_before_header' );
    
    /**
     * Header
     * 
     * @hooked seva_lite_header              - 20     
    */
    do_action( 'seva_lite_header' );
    
    /**
     * Content
     * 
     * @hooked seva_lite_content_start
    */
    do_action( 'seva_lite_content' );