jQuery(document).ready(function($){

    $('#sub-accordion-section-header_layout_section').on( 'click', '.header_layout_text', function(e){
        e.preventDefault();
        wp.customize.control( 'ed_shopping_cart' ).focus();        
    });

    $('#sub-accordion-section-header_settings').on( 'click', '.header_setting_text', function(e){
        e.preventDefault();
        wp.customize.control( 'header_layout' ).focus();        
    });

    $('#sub-accordion-section-banner_layout_section').on( 'click', '.cta_static_banner_layout_text', function(e){
        e.preventDefault();
        wp.customize.control( 'ed_banner_section' ).focus();        
    });
    
    $('#sub-accordion-section-header_image').on( 'click', '.cta_static_banner_text', function(e){
        e.preventDefault();
        wp.customize.control( 'banner_layout' ).focus();        
    });

});