jQuery(document).ready(function($) {


jQuery( document ).on( 'click', '#cat-list-button-id', function() {
    var post_id = jQuery(this).data('id-list');
    var category_name = jQuery(this).data('category-list');
    jQuery.ajax({
        url : catformlist.ajax_url,
        type : 'post',
        data : {
            action : 'form_list',
            post_id : post_id,
            category_name : category_name,
            security: catformlist.ajax_nonce
        },
        success : function( response ) {
            jQuery('#cat-display').html( response );

                jQuery(document).ready(function($) {
                    jQuery('button.btn').click(function() {

                    var submit_value = jQuery(this).attr("value");
            
                    var ajax_form_list = "#ajax-form-list-"+submit_value;

                    jQuery(ajax_form_list).submit(function(e){
                    var cat_name = jQuery("select#cat_name-"+submit_value+" option:selected").val();
                    var post_id = jQuery("#post_id-"+submit_value).val();
                    jQuery.ajax({
                                 url: catformlist.ajax_url,
                                 type: 'post',
                                 data:  {
                                        action: 'form_list',
                                        cat_name:cat_name,
                                        post_id:post_id,
                                        security: catformlist.ajax_nonce,
                                        submit_value: submit_value
                                        },
                                 success: function(response) {
                                            jQuery('#cat-form-output-'+submit_value).html( response ); //should print out the name since you sent it along
                                            //updatevalue();

                                        }
                                });

                        return false;

                        });

                    });
                });
            },

        error:function(exception){alert('Exeption:'+exception);}

    });

    return false;
});



});


//function updatevalue() {

/*
                jQuery(document).ready(function($) {
                    var submit_value = jQuery('button.btn').attr("value");
            
                    var ajax_form_list = "#ajax-form-list-"+submit_value;

                    jQuery(ajax_form_list).submit(function(e){
                    var cat_name = jQuery("select#cat_name-"+submit_value+" option:selected").val();
                    var post_id = jQuery("#post_id-"+submit_value).val();
                    jQuery.ajax({
                         url: catformlist.ajax_url,
                         type: 'post',
                         data: {
                                action: 'form_list',
                                cat_name:cat_name,
                                post_id:post_id,
                                security: catformlist.ajax_nonce,
                                submit_value : submit_value
                         },
                         success: function(response) {
                              jQuery('#cat-form-output-'+submit_value).html( response ); //should print out the name since you sent it along

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                    });

                    return false;

                    });

                 });*/

//}


/*

                jQuery(document).ready(function($) {
                    var submit_value = jQuery('button.btn').attr("value");
            
                    var ajax_form_list = "#ajax-form-list-"+submit_value;

                    jQuery(ajax_form_list).submit(function(e){
                    var cat_name = jQuery("select#cat_name-"+submit_value+" option:selected").val();
                    var post_id = jQuery("#post_id-"+submit_value).val();
                    jQuery.ajax({
                         url: catformlist.ajax_url,
                         type: 'post',
                         data: {
                                action: 'form_list',
                                cat_name:cat_name,
                                post_id:post_id,
                                security: catformlist.ajax_nonce,
                                submit_value : submit_value
                         },
                         success: function(response) {
                              jQuery('#cat-form-output-'+submit_value).html( response ); //should print out the name since you sent it along

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                    });

                    return false;

                    });

                 });*/