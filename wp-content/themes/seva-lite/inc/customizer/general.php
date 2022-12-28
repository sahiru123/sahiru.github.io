<?php
/**
 * General Settings
 *
 * @package Seva_Lite
 */

function seva_lite_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'seva-lite' ),
            'description' => __( 'Customize Header, Social, Sharing, SEO, Post/Page, Newsletter, Performance and Miscellaneous settings.', 'seva-lite' ),
        ) 
    );

    /** Header Settings Starts */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'seva-lite' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );
        
    /** Phone */
    $wp_customize->add_setting(
        'phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'phone',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Phone', 'seva-lite' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'phone', array(
        'selector' => '.site-header .header-block a.phone',
        'render_callback' => 'seva_lite_get_phone',
    ) );
    
    /** Email */
    $wp_customize->add_setting(
        'email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'email',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Email', 'seva-lite' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'email', array(
        'selector' => '.site-header .header-block a.email',
        'render_callback' => 'seva_lite_get_email',
    ) );

    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_contact_button', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_contact_button',
            array(
                'section'     => 'header_settings',
                'label'       => __( 'Enable Contact button', 'seva-lite' ),
                'description' => __( 'Enable contact button in header', 'seva-lite' ),
            )
        )
    );

    $wp_customize->add_setting(
        'header_contact_button',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'header_contact_button',
        array(
            'label'         => __( 'Header Button Label', 'seva-lite' ),
            'section'       => 'header_settings',
            'type'          => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'header_contact_button', array(
        'selector' => '.site-header .header-button-wrap .header-inquiry-btn',
        'render_callback' => 'seva_lite_get_header_contact_button',
    ) );

    $wp_customize->add_setting(
        'header_contact_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw', 
        )
    );
    
    $wp_customize->add_control(
        'header_contact_url',
        array(
            'label'     => __( 'Header Button Link', 'seva-lite' ),
            'section'   => 'header_settings',
            'type'      => 'url',
        )
    );

    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_header_new_tab', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_header_new_tab',
            array(
                'section'     => 'header_settings',
                'label'       => __( 'Open in new tab', 'seva-lite' ),
                'description' => __( 'Enable to open link in new tab.', 'seva-lite' ),
            )
        )
    );

    /** Header Settings Ends */

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'seva-lite' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'       => __( 'Enable Social Links', 'seva-lite' ),
                'description' => __( 'Enable to show social links at header.', 'seva-lite' ),
            )
        )
    );
    
    $wp_customize->add_setting( 
        new Seva_Lite_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Seva_Lite_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',               
                'label'   => __( 'Social Links', 'seva-lite' ),
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'seva-lite' ),
                        'description' => __( 'Example: fab fa-facebook-f', 'seva-lite' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'seva-lite' ),
                        'description' => __( 'Example: https://facebook.com', 'seva-lite' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'seva-lite' ),
                    'field' => 'link'
                ),
                'choices'   => array(
                    'limit' => 10
                )                          
            )
        )
    );
    /** Social Media Settings Ends */
    
    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'seva-lite' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Last Update Post Date', 'seva-lite' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'seva-lite' ),
            )
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'seva-lite' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'seva-lite' ),
            )
        )
    );
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'seva-lite' ),
        )
    );  
    /** SEO Settings Ends */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'seva-lite' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );
    
    /** Prefix Archive Page */
    $wp_customize->add_setting( 
        'ed_prefix_archive', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Prefix in Archive Page', 'seva-lite' ),
                'description' => __( 'Enable to hide prefix in archive page.', 'seva-lite' ),
            )
        )
    );
    
    /** Blog Post Image Crop */
    $wp_customize->add_setting( 
        'ed_crop_blog', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_crop_blog',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Blog Post Image Crop', 'seva-lite' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in home, archive and search posts.', 'seva-lite' ),
            )
        )
    );

    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Enable Blog Excerpt', 'seva-lite' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'seva-lite' ),
            )
        )
    );
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 30,
            'sanitize_callback' => 'seva_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Slider_Control( 
            $wp_customize,
            'excerpt_length',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Excerpt Length', 'seva-lite' ),
                'description' => __( 'Automatically generated excerpt length (in words).', 'seva-lite' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 5,
                )                 
            )
        )
    );
    
    $wp_customize->add_setting(
        'blog_featured_post',
        array(
            'default'           => '',
            'sanitize_callback' => 'seva_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Seva_Lite_Select_Control(
            $wp_customize,
            'blog_featured_post',
            array(
                'label'       => __( 'Blog Featured Post', 'seva-lite' ),
                'description' => __( 'Select a featured posts for blog.', 'seva-lite' ),
                'section'     => 'post_page_settings',
                'choices'     => seva_lite_get_posts(),    
            )
        )
    );

    /** Read More Text */
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __( 'Read More', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'read_more_text',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Read More Text', 'seva-lite' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'read_more_text', array(
        'selector' => '.entry-footer .btn-readmore',
        'render_callback' => 'seva_lite_get_read_more',
    ) );
    
    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Note_Control( 
            $wp_customize,
            'post_note_text',
            array(
                'section'     => 'post_page_settings',
                'description' => sprintf( __( '%s These options affect your individual posts.', 'seva-lite' ), '<hr/>' ),
            )
        )
    );

    /** Single Post Image Crop */
    $wp_customize->add_setting( 
        'ed_crop_single', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_crop_single',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Single Post Image Crop', 'seva-lite' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in single post.', 'seva-lite' ),
            )
        )
    );
    
    /** Hide Author Section */
    $wp_customize->add_setting( 
        'ed_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Author Section', 'seva-lite' ),
                'description' => __( 'Enable to hide author section.', 'seva-lite' ),
            )
        )
    );

    /** Author Section title */
    $wp_customize->add_setting(
        'author_subtitle',
        array(
            'default'           => __( 'About The Author', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'author_subtitle',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Author Section Subtitle', 'seva-lite' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'author_subtitle', array(
        'selector' => '.author-section .author-img-title-wrap .author-title-wrap .sub-title',
        'render_callback' => 'seva_lite_get_author_subtitle',
    ) );

    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Related Posts', 'seva-lite' ),
                'description' => __( 'Enable to show related posts in single page.', 'seva-lite' ),
            )
        )
    );
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'You may also like...', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Posts Section Title', 'seva-lite' ),
            'active_callback' => 'seva_lite_post_page_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.additional-post h5.post-title',
        'render_callback' => 'seva_lite_get_related_title',
    ) );

    $wp_customize->add_setting(
        'related_portfolio_title',
        array(
            'default'           => __( 'Related Projects', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_portfolio_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Portfolio Title', 'seva-lite' ),
        )
    );
    
    /** Comments */
    $wp_customize->add_setting(
        'ed_comments',
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Comments', 'seva-lite' ),
                'description' => __( 'Enable to show Comments in Single Post/Page.', 'seva-lite' ),
            )
        )
    );
    
    /** Comments Below Post Content */
    $wp_customize->add_setting(
        'toggle_comments',
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'toggle_comments',
            array(
                'section'         => 'post_page_settings',
                'label'           => __( 'Comments Below Post Content', 'seva-lite' ),
                'description'     => __( 'Enable to show comment section right after post content. Refresh site for changes.', 'seva-lite' ),
                'active_callback' => 'seva_lite_post_page_ac'
            )
        )
    );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Category', 'seva-lite' ),
                'description' => __( 'Enable to hide category.', 'seva-lite' ),
            )
        )
    );
    
    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'seva-lite' ),
                'description' => __( 'Enable to hide post author.', 'seva-lite' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Posted Date', 'seva-lite' ),
                'description' => __( 'Enable to hide posted date.', 'seva-lite' ),
            )
        )
    );
    
    /** Show Featured Image */
    $wp_customize->add_setting( 
        'ed_featured_image', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_featured_image',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Featured Image', 'seva-lite' ),
                'description' => __( 'Enable to show featured image in post detail (single post).', 'seva-lite' ),
            )
        )
    );

    /** Posts(Blog) & Pages Settings Ends */
    
    /** Newsletter Settings */
    $wp_customize->add_section(
        'newsletter_settings',
        array(
            'title'    => __( 'Newsletter Settings', 'seva-lite' ),
            'priority' => 65,
            'panel'    => 'general_settings',
        )
    );
    
    if( seva_lite_is_btnw_activated() ){
        
        /** Enable Newsletter Section */
        $wp_customize->add_setting( 
            'ed_newsletter', 
            array(
                'default'           => false,
                'sanitize_callback' => 'seva_lite_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Toggle_Control( 
                $wp_customize,
                'ed_newsletter',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Section', 'seva-lite' ),
                    'description' => __( 'Enable to show Newsletter Section', 'seva-lite' ),
                )
            )
        );
        
        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );
        
        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'newsletter_settings',
                'label'       => __( 'Newsletter Shortcode', 'seva-lite' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'seva-lite' ),
            )
        ); 
    } else {
        $wp_customize->add_setting(
            'newsletter_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new seva_lite_Plugin_Recommend_Control(
                $wp_customize,
                'newsletter_recommend',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Shortcode', 'seva-lite' ),
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-email-newsletter',//This is the slug of recommended plugin.
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s. After that option related with this section will be visible.', 'seva-lite' ), '<strong>', '</strong>' ),
                )
            )
        );
    }
    /** Newsletter Settings Ends*/

    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_settings',
        array(
            'title'    => __( 'Instagram Settings', 'seva-lite' ),
            'priority' => 70,
            'panel'    => 'general_settings',
        )
    );
    
    if( seva_lite_is_btif_activated() ){
        /** Enable Instagram Section */
        $wp_customize->add_setting( 
            'ed_instagram', 
            array(
                'default'           => false,
                'sanitize_callback' => 'seva_lite_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Toggle_Control( 
                $wp_customize,
                'ed_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __( 'Instagram Section', 'seva-lite' ),
                    'description' => __( 'Enable to show Instagram Section', 'seva-lite' ),
                )
            )
        );
        
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'You can change the setting of BlossomThemes Social Feed %1$sfrom here%2$s.', 'seva-lite' ), '<a href="' . esc_url( admin_url( 'admin.php?page=class-blossomthemes-instagram-feed-admin.php' ) ) . '" target="_blank">', '</a>' )
                )
            )
        );        
    }else{
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Seva_Lite_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Social Feed%2$s. After that option related with this section will be visible.', 'seva-lite' ), '<a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '" target="_blank">', '</a>' )
                )
            )
        );
    }
    /** Instagram Settings Ends*/

    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'seva-lite' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

    /** Enable Toggle */
    $wp_customize->add_setting( 
        'ed_wow_toggle', 
        array(
            'default'           => true,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_wow_toggle',
            array(
                'section'     => 'misc_settings',
                'label'       => __( 'Enable Animation', 'seva-lite' ),
                'description' => __( 'This feature will add animation to the different sections of your website.', 'seva-lite' ),
            )
        )
    );

    /** Shop Page Description */
    $wp_customize->add_setting( 
        'ed_shop_archive_description', 
        array(
            'default'           => false,
            'sanitize_callback' => 'seva_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Seva_Lite_Toggle_Control( 
            $wp_customize,
            'ed_shop_archive_description',
            array(
                'section'         => 'misc_settings',
                'label'           => __( 'Shop Page Description', 'seva-lite' ),
                'description'     => __( 'Enable to show Shop Page Description.', 'seva-lite' ),
                'active_callback' => 'seva_lite_is_woocommerce_activated'
            )
        )
    );

    /** Section title */

    $wp_customize->add_setting(
        'error_404_image',
        array(
            'default'           => get_template_directory_uri() . '/images/error.jpg',
            'sanitize_callback' => 'seva_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'error_404_image',
            array(
                'label'           => __( '404 Image', 'seva-lite' ),
                'description'     => __( 'Choose the background image for 404 page.', 'seva-lite' ),
                'section'         => 'misc_settings',
            )
        )
    );

    $wp_customize->add_setting( 
        'error_404_button_label', 
        array(
            'default'           => __( 'Go To Blog', 'seva-lite' ),
            'sanitize_callback' => 'sanitize_text_field'
        ) 
    );
    
    $wp_customize->add_control(
        'error_404_button_label',
        array(
            'section'         => 'misc_settings',
            'label'           => __( 'Button Label for 404 Page', 'seva-lite' ),
            'type'            => 'text',
        )
    );
    /** Miscellaneous Settings Ends*/
}
add_action( 'customize_register', 'seva_lite_customize_register_general' );