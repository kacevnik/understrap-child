<?php

/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (defined( 'FW' )){
    $price     = fw_get_db_post_option(get_the_ID(), 'kdv_object_price');
    $sq        = fw_get_db_post_option(get_the_ID(), 'kdv_object_sq');
    $slider    = fw_get_db_post_option(get_the_ID(), 'kdv_odject_slider');
    $adres     = fw_get_db_post_option(get_the_ID(), 'kdv_object_adres');
    $seller    = fw_get_db_post_option(get_the_ID(), 'kdv_object_select');
}

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

            <main class="site-main" id="main">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'loop-templates/content', 'object' ); ?>

                        <?php understrap_post_nav(); ?>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; // end of the loop. ?>

            </main><!-- #main -->

        <!-- Do the right sidebar check -->
        <?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

    </div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
