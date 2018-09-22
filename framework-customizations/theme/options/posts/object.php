<?php if (!defined( 'FW' )) die('Forbidden');

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Дополнительные настройки объекта', '{domain}'),
        'options' => array(
            'kdv_object_price' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Цена', '{domain}'),
                'desc'  => __('Укажите цену объекта', '{domain}')
            ),

            'kdv_object_sq' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Площадь', '{domain}'),
                'desc'  => __('Укажите площадь', '{domain}')
            ),

            'kdv_odject_slider' => array(
                'type' => 'addable-popup',
                'label' => __('Слайдер', '{domain}'),
                'desc'  => __('Добавьте картинки для слайдера в карточке товара', '{domain}'),
                'template' => '{{- name }}',
                'popup-title' => null,
                'size' => 'small', // small, medium, large
                'limit' => 0, // limit the number of popup`s that can be added
                'add-button-text' => __('Добавить', '{domain}'),
                'sortable' => true,
                'popup-options' => array(
                    'name' => array(
                        'label' => __('Название', '{domain}'),
                        'type' => 'text',
                        'desc' => __('название картинки(необязательно).', '{domain}'),
                    ),

                    'img' => array(
                        'type'  => 'upload',
                        'value' => array(
                            /*
                            'attachment_id' => '9',
                            'url' => '//site.com/wp-content/uploads/2014/02/whatever.jpg'
                            */
                            // if value is set in code, it is not considered and not used
                            // because there is no sense to set hardcode attachment_id
                        ),
                        'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'label' => __('Картика', '{domain}'),
                        'desc'  => __('', '{domain}'),
                        'help'  => __('Загрузите изображение слайда (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
                        /**
                         * If set to `true`, the option will allow to upload only images, and display a thumb of the selected one.
                         * If set to `false`, the option will allow to upload any file from the media library.
                         */
                        'images_only' => true,
                        /**
                         * An array with allowed files extensions what will filter the media library and the upload files.
                         */
                        'files_ext' => array( 'jpg', 'png', 'gif' ),
                        /**
                         * An array with extra mime types that is not in the default array with mime types from the javascript Plupload library.
                         * The format is: array( '<mime-type>, <ext1> <ext2> <ext2>' ).
                         * For example: you set rar format to filter, but the filter ignore it , than you must set
                         * the array with the next structure array( '.rar, rar' ) and it will solve the problem.
                         */
                        'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
                    )
                )
            ),

            'kdv_object_adres' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Адрес', '{domain}'),
                'desc'  => __('Укажите адрес объекта', '{domain}')
            ),

            'kdv_object_select' => array(
                'type'  => 'select',
                'value' => 'choice-3',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Продовец', '{domain}'),
                'desc'  => __('Укажите продовца', '{domain}'),
                'help'  => __('Компания или собственник', '{domain}'),
                'choices' => array(
                    '' => '---',
                    'Компания' => __('Компания', '{domain}'),
                    'Собственник' => __('Собственник', '{domain}')
                ),
                /**
                 * Allow save not existing choices
                 * Useful when you use the select to populate it dynamically from js
                 */
                'no-validate' => false,
            )
        )
    )
);