<?php


    add_action( 'widgets_init', 'add_form_widget' );

    function add_form_widget(){
        register_widget( 'AddFormWidget' );
    }

    class AddFormWidget extends WP_Widget{

        public function __construct(){
            $args = array(
                'name' => 'Форма добавления объекта',
                'description' => 'Выводит форму добавления объекта недвижемости'
            );

            parent::__construct('add_form_widget', '', $args);
        }

        public function form($instatce){
            //print_r($instatce);
            $title = isset($instatce['title']) ? $instatce['title'] : 'Добавить новый объект недвижемости';
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">Заголовок</label>
                    <input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $title; ?>" class="widefat">
                </p>

                <p>
            <?php
            $posts = get_posts( array(
                    'numberposts' => 5,
                    'category'    => 0,
                    'orderby'     => 'name',
                    'order'       => 'DESC',
                    'include'     => array(),
                    'exclude'     => array(),
                    'meta_key'    => '',
                    'meta_value'  =>'',
                    'post_type'   => 'page',
                    'suppress_filters' => true,
                ) );
                if(count($posts)){
                echo '<p>Где показывать?</p>';
                echo '<p>';
                ?>
                        <input type="checkbox" name="<?php echo $this->get_field_name('all'); ?>" id="<?php echo $this->get_field_id('all'); ?>" value="all" <?php if($instatce['all']){echo " checked";} ?>>
                        <label for="<?php echo $this->get_field_id('all'); ?>">Везде</label><br>
                <?php
                foreach ($posts as $post) {
                    ?>
                        <input type="checkbox" class="all_check_child" name="<?php echo $this->get_field_name('post'); ?>[]" id="<?php echo $this->get_field_id('post').$post->ID; ?>" value="<?php echo $post->ID; ?>" <?php if(is_array($instatce['post']) && in_array($post->ID, $instatce['post'])){echo " checked";} ?>><label for="<?php echo $this->get_field_id('post').$post->ID; ?>"><?php if($post->post_title ){echo $post->post_title;}else{echo '<i>Не указанно ('.$post->post_name.')</i>';} ?></label><br>
                    <?php
                }
                echo '</p>';
            }
        }

        public function widget($args, $instatce){

            if(isset($instatce['all']) || in_array(get_the_ID(), $instatce['post'])){
            ?>
                <div class="add_form">
                    <h2>Добавить новый объект недвижемости</h2>
                    <form action="" method="post" id="add_object_form" enctype="multipart/form-data">
                        <input type="text" name="object_name" required="required" placeholder="Название объекта"><br>
                        <input type="text" name="object_price" required="required" placeholder="Цена объекта"><br>
                        <input type="text" name="object_adres" required="required" placeholder="Адрес объекта"><br>
                        <input type="text" name="object_sq" required="required" placeholder="Площадь объекта"><br>
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
                        </select><br>
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
                        </select><br>
                        <select name="seller">
                            <option value="Компания">Компания</option>
                            <option value="Собственник">Собственник</option>
                        </select><br>
                        <input type="file" name="obj_img" id="my_image_upload"  multiple="false"><br>
                        <textarea name="object_desc" placeholder="Описание объекта"></textarea> <br>
                        <input type="submit" name="submit" value="Отправить" id="add_new_object">
                    </form>
                </div>
                <!-- /.add_form -->
                <a id="click_thanks_message" data-fancybox data-src="#thanks_message" href="javascript:;">Спасибо</a>
                <div id="thanks_message">
                    <h2>Спасибо!<br>После проверки, Ваш объект будет добавлен!</h2>
                </div>
                <!-- /.thanks_message -->

            <?php
            }
        }
    }

?>