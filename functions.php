<?php

    /* creat new size picture for object thumb */

    add_theme_support('post-thumbnails');
    add_image_size('object-thumb', 300, 180, true);

    /* add check set plag-in Unyson */
    /* docs for unyson http://manual.unyson.io/en/latest/ */

    if (!defined( 'FW' )){
        function com_version_wp(){
            $action = 'install-plugin';
            $slug = 'unyson';
            $url = wp_nonce_url(
                add_query_arg(
                    array(
                        'action' => $action,
                        'plugin' => $slug
                    ),
                    admin_url( 'update.php' )
                ),
                $action.'_'.$slug
            );
            echo    '<div class="notice notice-error">
                        <p>Внимание! Для правильной работы должен быть установлен и активирован плагин Unyson! <a data-slug="unyson" href="'. $url .'" aria-label="Установить Unyson сейчас" class="install-now button">Установить</a></p>
                    </div>';
        }
        add_action('admin_notices', 'com_version_wp');
    }

/* add custom JS and CSS files */

    add_action( 'wp_enqueue_scripts', 'enqueue_cusiom_scripts' );

    if(!function_exists( 'enqueue_cusiom_scripts') ) {

        function enqueue_cusiom_scripts() {

            if(is_admin()) return false;

            wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri().'/css/jquery.fancybox.min.css', array(), '3.4.2', 'all' );
            wp_enqueue_style( 'main-style', get_stylesheet_directory_uri().'/css/style.css', array(), '1.0.0', 'all' );

            wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri().'/js/jquery.fancybox.min.js', array('jquery'),'3.4.2', true );
            wp_enqueue_script( 'main', get_stylesheet_directory_uri().'/js/main.js', array('jquery'),'3.4.2', true );

        }

    }


/* add costom type taxonomy */

add_action( 'init', 'create_taxonomy_object' );
    function create_taxonomy_object(){
        register_taxonomy( 'cat_object', array('object' ), array(
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => array(
                'name' => _x( 'Тип недвижемости', 'taxonomy general name' ),
                'singular_name' => _x( 'Тип недвижемости', 'taxonomy singular name' ),
                'search_items' =>  __( 'Искать типы недвижемости' ),
                'all_items' => __( 'Все типы недвижемости' ),
                'parent_item' => __( 'Родительский тип недвижемости' ),
                'parent_item_colon' => __( 'Родительский тип недвижемости:' ),
                'edit_item' => __( 'Редактировать тип недвижемости' ),
                'update_item' => __( 'Обновить тип недвижемости' ),
                'add_new_item' => __( 'Добавить тип недвижемости' ),
                'new_item_name' => __( 'Новый тип недвижемости' ),
                'menu_name' => __( 'Типы недвижемости' ),
            ),
            'description'           => '',
            'public'                => true,
            'publicly_queryable'    => null,
            'show_in_nav_menus'     => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_tagcloud'         => true,
            'show_in_rest'          => null,
            'rest_base'             => null,
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => true,
            //'query_var'             => $taxonomy,
            'capabilities'          => array(),
            'meta_box_cb'           => null,
            'show_admin_column'     => false,
            '_builtin'              => false,
            'show_in_quick_edit'    => null,
        ) );
    }

    /* add custom type post */

    add_action( 'init', 'register_post_types_object' );
    function register_post_types_object(){
        register_post_type( 'object', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Недвижемость',
                'singular_name'      => 'Недвижемость',
                'add_new'            => 'Добавить недвижемость',
                'add_new_item'       => 'Добавление недвижемости',
                'edit_item'          => 'Редактирование недвижемости',
                'new_item'           => 'Новая недвижемость',
                'view_item'          => 'Смотреть недвижемость',
                'search_items'       => 'Искать недвижемость',
                'not_found'          => 'Не найдено',
                'not_found_in_trash' => 'Не найдено в корзине',
                'parent_item_colon'  => '',
                'menu_name'          => 'Недвижемость',
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null,
            'exclude_from_search' => null,
            'show_ui'             => null,
            'show_in_menu'        => null,
            'show_in_admin_bar'   => null,
            'show_in_nav_menus'   => null,
            'show_in_rest'        => null,
            'rest_base'           => null,
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-admin-multisite', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post',
            //'map_meta_cap'      => null,
            'hierarchical'        => false,
            'supports'            => array('title','editor','thumbnail','excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array('cat_sistem'),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }