<?php

    include ('inc/shortcode_last_object.php');
    include ('inc/shortcode_last_town.php');
    include ('inc/widget_add_object.php');

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

/* register new area wdgets in theme */
    register_sidebar( array(
        'name' => 'Область над футером',
        'id' => 'widget_for_form',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ) );

/* add custom JS and CSS files */

    add_action( 'wp_enqueue_scripts', 'enqueue_cusiom_scripts' );

    if(!function_exists( 'enqueue_cusiom_scripts') ) {

        function enqueue_cusiom_scripts() {

            if(is_admin()) return false;

            wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri().'/css/jquery.fancybox.min.css', array(), '3.4.2', 'all' );
            wp_enqueue_style( 'main-style', get_stylesheet_directory_uri().'/css/style.css', array(), '1.0.0', 'all' );

            wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri().'/js/jquery.fancybox.min.js', array('jquery'),'3.4.2', true );
            wp_enqueue_script( 'main', get_stylesheet_directory_uri().'/js/main.js', array('jquery'),'1.0.0', true );

            wp_localize_script( 'main', 'addObject', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'add-object' )
            ) );

        }

    }

/* function adding new object with help ajax*/

    add_action('wp_ajax_add_custom_object', 'add_custom_object');
    add_action('wp_ajax_nopriv_add_custom_object', 'add_custom_object');

    function add_custom_object(){
        if ( empty( $_POST['nonce'] ) ) {
            wp_die( '0' );
        }

        if ( wp_verify_nonce( $_POST['nonce'], 'add-object' ) ) {
            $post_data = array(
                'post_title'    => wp_strip_all_tags( $_POST['name'] ),
                'post_content'  => $_POST['desc'],
                'post_status'   => 'draft',
                'post_type'     => 'object',
                'post_parent'   => ( int )abs( $_POST['town'] )
            );

            $post_id = wp_insert_post( $post_data );
            wp_set_post_terms( $post_id, array( ( int )abs( $_POST['type_obj'] ) ), 'cat_object', false );

            $data = array(
                'kdv_object_price'  => esc_html( $_POST['price'] ),
                'kdv_object_sq'     => esc_html( $_POST['sq'] ),
                'kdv_object_adres'  => esc_html( $_POST['adres'] ),
                'kdv_object_select' => esc_html( $_POST['seller'] )
            );

            add_post_meta( $post_id, 'fw_options', $data );

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            
            add_filter( 'upload_mimes', function( $mimes ){
                return [
                    'jpg|jpeg|jpe' => 'image/jpeg',
                    'gif'          => 'image/gif',
                    'png'          => 'image/png',
                ];
            } );

            $uploaded_imgs = array();

            foreach( $_FILES as $file_id => $data ){
                $attach_id = media_handle_upload( $file_id, $post_id );
                update_post_meta( $post_id, '_thumbnail_id', $attach_id );

                if( is_wp_error( $attach_id ) )
                    $uploaded_imgs[] = 'Ошибка загрузки файла `'. $data['name'] .'`: '. $attach_id->get_error_message();
                else
                    $uploaded_imgs[] = wp_get_attachment_url( $attach_id );
            }

        }else {
            wp_die( '0' );
        }

        wp_die();
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

    /* add custom type post object*/

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

/* add custom type post town*/

    add_action( 'init', 'register_post_types_town' );
    function register_post_types_town(){
        register_post_type( 'town', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Город',
                'singular_name'      => 'Город',
                'add_new'            => 'Добавить город',
                'add_new_item'       => 'Добавление города',
                'edit_item'          => 'Редактирование города',
                'new_item'           => 'Новый город',
                'view_item'          => 'Смотреть город',
                'search_items'       => 'Искать город',
                'not_found'          => 'Не найдено',
                'not_found_in_trash' => 'Не найдено в корзине',
                'parent_item_colon'  => '',
                'menu_name'          => 'Города',
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
            'menu_icon'           => 'dashicons-location', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post',
            //'map_meta_cap'      => null,
            'hierarchical'        => false,
            'supports'            => array('title','editor','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array(),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    // add metabox cities for object
    add_action('add_meta_boxes', function () {
        add_meta_box( 'city_object', 'Город', 'city_object_metabox', 'object', 'side', 'low'  );
    }, 1);

    function city_object_metabox( $post ){
        $cities = get_posts(array( 'post_type'=>'town', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ));

        if( $cities ){
            echo '
            <div style="max-height:200px; overflow-y:auto;">
                <ul>
            ';

            foreach( $cities as $city ){
                echo '
                <li><label>
                    <input type="radio" name="post_parent" value="'. $city->ID .'" '. checked($city->ID, $post->post_parent, 0) .'> '. esc_html($city->post_title) .'
                </label></li>
                ';
            }

            echo '
                </ul>
            </div>';
        }
        else
            echo 'Городов нет...';
    }

    // add metabox object for cities
    add_action( 'add_meta_boxes', function(){
        add_meta_box( 'meta-object', 'Объекты недвижемости', 'object_city_metabox', 'town', 'side', 'low' );
    }, 1 );

    function object_city_metabox( $post ){
        $objects = get_posts( array( 'post_type'=>'object', 'post_parent'=>$post->ID, 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ) );

        if( $objects ){
            foreach( $objects as $object ){
                echo '<a href="'.get_permalink( $object->ID ).'" target=_blank">'.$object->post_title .'</a><br>';
            }
        }
        else
            echo 'Объектов нет...';
    }

    function change_admin_footer () {
        return '<i>Спасибо вам за творчество с <a href="http://wordpress.org">WordPress</a>; Всегда Ваш: <a href="https://www.fl.ru/users/kacevnik/">Дмитрий Ковалев</a></i>';
    }
    add_filter( 'admin_footer_text', 'change_admin_footer' );


