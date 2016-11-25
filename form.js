jQuery(document).ready(function($) {

jQuery('#ajax-form-list').submit(function(e){
    var cat_name = jQuery("select#cat_name option:selected").val();
    var post_id = jQuery("#post_id").val();
    jQuery.ajax({ 
         url: catformlist.ajax_url,         
		 type: 'post',
         data: {
         		action: 'form_list', 
         		cat_name:cat_name,
         		post_id:post_id,
         		security: catformlist.ajax_nonce
         },
         success: function(response) {
              jQuery('#cat-form-output').html( response ); //should print out the name since you sent it along

        }
    });

    return false;

});


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
        }
    });

    return false;
});

});