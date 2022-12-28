<?php
/**
 * Template Name: Custom Home Page
 */
get_header(); ?>

<main id="content">
  <?php if( get_theme_mod('yoga_studio_slider_arrows') != ''){ ?>
    <section id="slider" class="p-3 p-md-5">
      <span class="design-right"></span>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
        <?php
          for ( $yoga_studio_i = 1; $yoga_studio_i <= 4; $yoga_studio_i++ ) {
            $yoga_studio_mod =  get_theme_mod( 'yoga_studio_post_setting' . $yoga_studio_i );
            if ( 'page-none-selected' != $yoga_studio_mod ) {
              $yoga_studio_slide_post[] = $yoga_studio_mod;
            }
          }
           if( !empty($yoga_studio_slide_post) ) :
          $yoga_studio_args = array(
            'post_type' =>array('post'),
            'post__in' => $yoga_studio_slide_post
          );
          $yoga_studio_query = new WP_Query( $yoga_studio_args );
          if ( $yoga_studio_query->have_posts() ) :
            $yoga_studio_i = 1;
        ?>
        <div class="carousel-inner" role="listbox">
          <?php  while ( $yoga_studio_query->have_posts() ) : $yoga_studio_query->the_post(); ?>
          <div <?php if($yoga_studio_i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <div class="container">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 slide-content">
                  <div class="carousel-caption text-center text-md-left text-sm-left">
                  <h2><?php the_title();?></h2>
                  <p class="mb-0"><?php echo esc_html(wp_trim_words(get_the_content(),'20') );?></p>
                  <div class="home-btn text-center text-md-left text-sm-left my-4">
                    <a class="py-3 px-4" href="<?php the_permalink(); ?>"><?php echo esc_html('Register Now','yoga-studio'); ?></a>
                  </div>
                </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 image-content">
                  <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>"/>
                </div>
              </div>
            </div>
          </div>
          <?php $yoga_studio_i++; endwhile;
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
        <div class="no-postfound"></div>
          <?php endif;
        endif;?>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon px-3 py-2" aria-hidden="true"><i class="fas fa-long-arrow-alt-left"></i></span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon px-3 py-2" aria-hidden="true"><i class="fas fa-long-arrow-alt-right"></i></span>
          </a>
      </div>
      <span class="design-left"></span>
      <div class="clearfix"></div>
    </section>
  <?php }?>

  <?php if( get_theme_mod('yoga_studio_services_enable') != ''){ ?>
    <?php if( get_theme_mod('yoga_studio_services_section_title') != '' || get_theme_mod('yoga_studio_services_section_text') != '' || get_theme_mod('yoga_studio_category_setting') != ''){ ?>
      <section id="services-box" class="py-5">
        <span class="design-right"></span>
        <div class="container">
          <h3 class="text-center mb-2"><?php echo esc_html( get_theme_mod( 'yoga_studio_services_section_title','') ); ?></h3><span class="heading-bg"></span>
          <p class="text-center mb-5"><?php echo esc_html( get_theme_mod( 'yoga_studio_services_section_text','') ); ?></p>
          <div class="row">
            <?php
              $yoga_studio_services_category=  get_theme_mod('yoga_studio_category_setting');if($yoga_studio_services_category){
              $yoga_studio_page_query = new WP_Query(array( 'category_name' => esc_html($yoga_studio_services_category ,'yoga-studio')));?>
                <?php while( $yoga_studio_page_query->have_posts() ) : $yoga_studio_page_query->the_post(); ?>  
                  <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="box mb-lg-5 mb-3 text-center">
                      <div class="img-box mb-3">
                        <?php the_post_thumbnail(); ?>
                      </div>
                      <a href="<?php the_permalink(); ?>"><h4><?php the_title();?></h4></a>
                    </div>
                  </div>
                <?php endwhile;
              wp_reset_postdata();
            }?>
          </div>
        </div>
      </section>
    <?php }?>
  <?php } ?>
</main>

<?php get_footer(); ?>