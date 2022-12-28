jQuery(document).ready(function($) {

    var rtl;
    
    if( seva_lite_data.rtl == '1' ){
        rtl = true;
    }else{
        rtl = false;
    }
    /**
    * =========================
    * wow animation initialization
    * =========================
    */
    
    if ( seva_lite_data.ed_wow == '1' ) {
        $('.service-section').find('.widget_text').attr({ 'data-wow-duration': '1s', 'data-wow-delay': '0.1s' }).addClass("wow fadeInUp");
        $('.service-section').find('.widget_bttk_icon_text_widget').attr({ 'data-wow-duration': '1s', 'data-wow-delay': '0.1s' }).addClass("wow fadeInUp");
        
        new WOW().init();
    }
     /**
    * =========================
    * wow animation initialization End
    * =========================
    */
    

    /**
    * =========================
    * instagram responsive
    * =========================
    */
       
    function instagramViewUpdate() {
        var viewportWidth = $(window).width();
        if (viewportWidth < 768) {
            $(".instagram-section .popup-gallery").removeClass("photos-6").addClass("photos-3");
        }
    }
    $(window).load(instagramViewUpdate);
    $(window).resize(instagramViewUpdate);
    /**
     * =========================
     * instagram responsive
     * =========================
     */

    //add submenu toggle btn
    $('.site-header:not(.style-six >.header-main) .nav-menu .menu-item-has-children').find('> a').after('<button class="submenu-toggle" type="button"><i class="fas fa-caret-down"></i></button>');

    //for accessibility
    $('.main-navigation li a, .footer-navigation li a, .main-navigation li button').on('focus', function () {
        $(this).parents('li').addClass('hover');
    }).blur(function(){
        $(this).parents('li').removeClass('hover');
    });

    //toggle secondary menu in header seven
    $('.site-header .header-top .secondary-menu > div, .site-header .header-main .secondary-menu > div').prepend('<button id="closeBttn" class="close "></button>');

    $('.site-header:not(.style-six  >.header-main) .secondary-menu .toggle-btn').click(function() {
        $('body').addClass('menu-active');
        $(this).siblings('div').animate({
            width: 'toggle',
        });
    });
    
    $('.site-header:not(.style-six  >.header-main) .secondary-menu .close').click(function () {
        $('body').removeClass('menu-active');
        $(this).parent('div').animate({
            width: 'toggle',
        });
    });

    $('.submenu-toggle').on('click', function(){
        $(this).toggleClass('active');
        $(this).siblings('.sub-menu').stop().slideToggle();
    });



    $('.site-header .mobile-header .toggle-btn-wrap .toggle-btn').click(function () {
        $('body').addClass('mobile-menu-active');
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("transform", "translate(0px,0)");
    });
    $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner .container .mobile-header-wrap > .close').click(function () {
        $('body').removeClass('mobile-menu-active');
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("transform", "translate(-100%,0)");
    });

    if( seva_lite_data.ed_service_count == '1' ) {
        // service section
        var total_service_widget = $('.service-widget-wrapper > .widget_bttk_icon_text_widget').length;
        $('.service-widget-wrapper > .widget .text-holder').prepend('<span class="item-count">'+total_service_widget+'</span>');
    }

    if( seva_lite_data.ed_testimonial_count == '1' ) {
        // service section
        var total_testimonial_widget = $('.testimonial-inner-wrapper > .widget_bttk_testimonial_widget').length;
        $('.testimonial-inner-wrapper > .widget').prepend('<span class="slider-counter">'+total_testimonial_widget+'</span>');
    }

    // back to top
    $(window).scroll(function(){
        if($(window).scrollTop() > 200){
            $('#back-to-top-btn').addClass('show');
        }else{
            $('#back-to-top-btn').removeClass('show');
        }
    });
    $('#back-to-top-btn').on('click', function(){
        $('html, body').animate({
            scrollTop: $('html, body').offset().top
        });
    });


    // client slider
    var client_sec_title = $('.client-section .widget-title').text();
    $('.client-section .widget-title').html('<span>'+client_sec_title+'</span>');
    $('.client-section .blossom-inner-wrap').addClass('owl-carousel');
    if ($('.client-section .blossom-inner-wrap .image-holder').length > 5) {
        itemLoop = true;
    } else {
        itemLoop = false;
    }
    $('.client-section .blossom-inner-wrap').owlCarousel({
        items:5,
        margin:10,
        loop: itemLoop,
        autoplay: true,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:2,
                nav:false,
                dots:true,
            },
            768:{
                items:3
            },
            1200:{
                items:5
            }
        }
    });

    var testimonial_auto, testimonial_loop;
    
    if( seva_lite_data.t_auto == '1' ){
        testimonial_auto = true;
    }else{
        testimonial_auto = false;
    }

    if( seva_lite_data.t_loop == '1' ){
        testimonial_loop = true;
    }else{
        testimonial_loop = false;
    }

    // testimonial slider
    $('.testimonial-inner-wrapper').on('initialized.owl.carousel changed.owl.carousel', function(e) {
        if (!e.namespace)  {
            return;
        }
        var carousel = e.relatedTarget;
        $(this).find('.slider-counter').text(carousel.relative(carousel.current()) + 1 + '/' + carousel.items().length);
    }).owlCarousel({
        margin:10,
        nav:true,
        dots:false,
        items:1,
        rtl: rtl,
        autoplay: testimonial_auto,
        loop: testimonial_loop,
        autoplaySpeed: 1000,
        autoplayTimeout: seva_lite_data.t_speed,
    });

    
    var slider_auto, slider_loop;
    
    if( seva_lite_data.auto == '1' ){
        slider_auto = true;
    }else{
        slider_auto = false;
    }
    
    if( seva_lite_data.loop == '1' ){
        slider_loop = true;
    }else{
        slider_loop = false;
    }
    
    // banner slider
    $('.banner-slider .item-wrap').owlCarousel({
        items          : 1,
        loop           : slider_loop,
        mouseDrag      : false,
        margin         : 0,
        nav            : true,
        dots           : false,
        autoplay       : slider_auto,
        navText        : '',
        rtl            : rtl,
        lazyLoad       : true,
        autoplaySpeed  : 1000,
        animateOut     : seva_lite_data.animation,
        autoplayTimeout: seva_lite_data.speed,
    });

    // for testimonial
    var testi_item = $('.testimonial-inner-wrapper .process-slider.owl-loaded .owl-item').length;
    $('.testimonial-inner-wrapper .process-slider.owl-loaded').append('<span class="slider-counter">1/'+testi_item+'</span>');

    
    //Ajax for Add to Cart
    $('.btn-simple').on( 'click', function() {     
        $(this).addClass('adding-cart');
        var product_id = $(this).attr('id');
        
        $.ajax ({
            url     : seva_lite_data.ajax_url,  
            type    : 'POST',
            data    : 'action=seva_lite_add_cart_single&product_id=' + product_id,    
            success : function(results){
                $('#'+product_id).replaceWith(results);
            }
        }).done(function(){
            var cart = $('#cart-'+product_id).val();
            $('.cart .number').html(cart);         
        });
    });

  
    /**
     * =========================
     * Accessibility codes start
     * =========================
     */
    $(document).on('mousemove', 'body', function (e) {
        $(this).removeClass('keyboard-nav-on');
    });
    $(document).on('keydown', 'body', function (e) {
        if (e.which == 9) {
            $(this).addClass('keyboard-nav-on');
        }
    });
    /**
     * =========================
     * Accessibility codes end
     * =========================
     */


     
});

