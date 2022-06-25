/*
 * This JS file is loaded for the backend area.
 */

jQuery(document).ready(function($) {

    // Make section sortable.
    $("#parent-row").sortable({
        connectWith: ".connectedSortable",
    }).disableSelection();

});


// Used for upload the image.
function wp_add_image(obj) {

    var parent = jQuery(obj).parent().parent('div.field_row');
    var inputField = jQuery(parent).find(".form_field");

    var button = jQuery(obj),
        custom_uploader = wp.media({
            title: 'Upload Image',
            library: {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type: 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false
        }).on('select', function() { // it also has "open" and "close" events
            var attachment = custom_uploader.state().get('selection').first().toJSON();

            jQuery(parent).find("div.image_wrap").html('<img src="' + attachment.url + '" width="128" height="130">');

            inputField.html('');
            inputField.append('<input type="hidden" class="meta_image_url" name="wp_customss_images_upload[]" value="' + attachment.url + '" />');

            jQuery(obj).val('Edit Image');
            jQuery(obj).parent().find('.btn-remove-image').show();
        }).open();

    return false;
}


// Used for remove the selected image. 
function wp_remove_image(obj) {
    var parent = jQuery(obj).parent().parent();
    parent.remove();
}


// Used for add new side image section. 
function wp_add_new_slide() {
    var row = jQuery('#child-row').html();
    jQuery(row).appendTo('#parent-row');
}