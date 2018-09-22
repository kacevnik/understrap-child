<?php
/**
 * Single post partial template.
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
    $adress     = fw_get_db_post_option(get_the_ID(), 'kdv_object_adres');
    $seller    = fw_get_db_post_option(get_the_ID(), 'kdv_object_select');
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta">

            <?php understrap_posted_on(); ?>

        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->
    
    <div class="object-thumbail">
        <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
    </div>
    <!-- /.object-thumbail -->


    <?php if( count($slider) > 0 ) { ?>
    <div class="post-slider">
        <?php foreach ( $slider as $slide ) { ?>

        <div class="post-slider-item">
            <a href="<?php echo wp_get_attachment_image_url( $slide['img']['attachment_id'], 'full' ); ?>" data-fancybox="images">
                <img src="<?php echo wp_get_attachment_image_url( $slide['img']['attachment_id'], 'object-thumb' ); ?>" alt="">
            </a>
        </div>

    <?php } ?>
    </div>
    <?php } ?>

    <div class="entry-content">

        <?php the_content(); ?>

        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
            'after'  => '</div>',
        ) );
        ?>

    </div><!-- .entry-content -->

    <footer class="entry-footer">

        <?php understrap_entry_footer(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
