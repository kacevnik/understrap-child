<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    function cities_shortcode( $atts ){

        extract( shortcode_atts( array(
            'title' => 'Заголовок городов',
            'count' => '8'
        ), $atts ) );

        $posts = get_posts( array(
            'numberposts' => $count,
            'category'    => 0,
            'orderby'     => 'date',
            'order'       => 'DESC',
            'post_type'   => 'town',
            'suppress_filters' => true
        ) );

        $output = '';
        $output = '<h2 class="list_last_objects_header">'.$title.'</h2>';
        $output.= '<div class="row list_last_objects">';

        foreach( $posts as $post ){

            $output.= '<div class="col-xl-3 col-lg-4 col-md-6">';
            $output.= '<div class="list_last_objects_item cities">';
            $output.= '<a href="'.get_permalink( $post->ID ).'">';
            $output.= get_the_post_thumbnail( $post->ID, 'object-thumb' );
            $output.= '</a>';
            $output.= '<h4><a href ="'.get_permalink( $post->ID ).'">'.$post->post_title.'</a></h4>';
            $output.= '<a href="'.get_permalink( $post->ID ).'" class="more">Подробнее ...</a>';
            $output.= '</div>';
            $output.= '</div>';
        }

        $output.= '</div>';

        return $output;

    }

    add_shortcode( 'cities', 'cities_shortcode' );

?>