<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    function last_object_shortcode( $atts ){

        extract( shortcode_atts( array(
            'title' => 'Заголовок последних объектов',
            'count' => '10'
        ), $atts ) );

        $posts = get_posts( array(
            'numberposts' => $count,
            'category'    => 0,
            'orderby'     => 'date',
            'order'       => 'DESC',
            'post_type'   => 'object',
            'suppress_filters' => true
        ) );

        $output = '';
        $output = '<h2 class="list_last_objects_header">'.$title.'</h2>';
        $output.= '<div class="row list_last_objects">';

        foreach( $posts as $post ){
            $price     = fw_get_db_post_option( $post->ID, 'kdv_object_price' );
            $sq        = fw_get_db_post_option( $post->ID, 'kdv_object_sq' );
            $adress    = fw_get_db_post_option( $post->ID, 'kdv_object_adres' );
            $seller    = fw_get_db_post_option( $post->ID, 'kdv_object_select' );

            $output.= '<div class="col-xl-3 col-lg-4 col-md-6">';
            $output.= '<div class="list_last_objects_item">';
            $output.= '<a href="'.get_permalink( $post->ID ).'">';
            $output.= get_the_post_thumbnail( $post->ID, 'object-thumb' );
            $output.= '</a>';
            $output.= '<h4><a href ="'.get_permalink( $post->ID ).'">'.$post->post_title.'</a></h4>';
            $output.= '<p>Адресс: '.$adress.'</p>';
            $output.= '<p>Площадь: '.$sq.'</p>';
            $output.= '<p>Продовец: '.$seller.'</p>';
            $output.= '<p>Стоимость: '.$price.'</p>';
            $output.= '<a href="'.get_permalink( $post->ID ).'" class="more">Подробнее ...</a>';
            $output.= '</div>';
            $output.= '</div>';
        }

        $output.= '</div>';

        return $output;

    }

    add_shortcode( 'last_object', 'last_object_shortcode' );

?>