<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="add_form">
    <h2>Добавить новый объект недвижемости</h2>
    <form action="" method="post" id="add_object_form" enctype="multipart/form-data">
        <input type="text" name="object_name" required="required" placeholder="Название объекта">
        <input type="text" name="object_price" required="required" placeholder="Цена объекта">
        <input type="text" name="object_adres" required="required" placeholder="Адрес объекта">
        <input type="text" name="object_sq" required="required" placeholder="Площадь объекта">
        <select name="type_object">
            <option value="0">Тип недвижемости</option>
            <?php 
                $cat_object = get_categories( array(
                    'type'         => 'object',
                    'taxonomy'     => 'cat_object',
                ) );

                foreach ( $cat_object as $cat_object_item ) {
                ?>
                <option value="<?php echo $cat_object_item->term_id; ?>"><?php echo $cat_object_item->name; ?></option>
                <?php
                }

            ?>
        </select>
        <select name="town">
            <option value="0">Выбрать город</option>
            <?php
                $cities = get_posts( array( 'post_type'=>'town', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ) );
                foreach ( $cities as $city ) {
                ?>
                    <option value="<?php echo $city->ID; ?>"><?php echo $city->post_title; ?></option>
                <?php
                }
            ?>
        </select>
        <select name="seller">
            <option value="Компания">Компания</option>
            <option value="Собственник">Собственник</option>
        </select>
        <input type="file" name="obj_img" id="my_image_upload"  multiple="false">
        <textarea name="object_desc" placeholder="Описание объекта"></textarea> 
        <input type="submit" name="submit" value="Отправить" id="add_new_object">
    </form>
</div>
<!-- /.add_form -->

<div class="wrapper" id="wrapper-footer">

    <div class="<?php echo esc_attr( $container ); ?>">

        <div class="row">

            <div class="col-md-12">

                <footer class="site-footer" id="colophon">

                    <div class="site-info">

                        <?php understrap_site_info(); ?>

                    </div><!-- .site-info -->

                </footer><!-- #colophon -->

            </div><!--col end -->

        </div><!-- row end -->

    </div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

