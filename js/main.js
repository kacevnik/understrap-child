jQuery(document).ready(function($) {

    var files;

    $('input[type=file]').on('change', function(){
        files = this.files;
    });

    
    $("#add_object_form").submit(function(e){
        e.preventDefault();

        if( typeof files == 'undefined' ) return;

        var data = new FormData();

        $.each( files, function( key, value ){
            data.append( key, value );
        });

        data.append( 'my_file_upload', 1 );
        data.append( 'nonce', addObject.nonce );
        data.append( 'action', 'add_custom_object', );
        data.append( 'name', $('input[name=object_name]').val() );
        data.append( 'adres', $('input[name=object_adres]').val() );
        data.append( 'price', $('input[name=object_price]').val() );
        data.append( 'desc', $('textarea[name=object_desc]').val() );
        data.append( 'sq', $('input[name=object_sq]').val(), );
        data.append( 'type_obj', $('select[name=type_object] option:selected').val() );
        data.append( 'town', $('select[name=town] option:selected').val() );
        data.append( 'seller', $('select[name=seller] option:selected').val() );

        $(this).find('#add_new_object').prop('disabled', true);
        $('#add_object_form').animate({'opacity': '0.5'}, 300);

        $.ajax({
            url         : addObject.ajaxurl,
            type        : 'POST',
            data        : data,
            cache       : false,
            processData : false,
            contentType : false, 
            success     : function( response, status, jqXHR ){

                if( typeof response.error === 'undefined' ){
                    console.log(response);
                }
                else {
                    console.log('ОШИБКА: ' + respond.error );
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }

        });

        $( 'input[name=object_name]' ).val( '' ),
        $( 'input[name=object_price]' ).val( '' ),
        $( 'input[name=object_adres]' ).val( '' ),
        $( 'textarea[name=object_desc]' ).val( '' ),
        $( 'input[name=object_sq').val( '' ),
        $( this).find('#add_new_object' ).prop( 'disabled', true) ;
        $( '#add_object_form' ).animate( {'opacity': '1'}, 300 );
        $("#click_thanks_message").trigger("click");

    });

});;