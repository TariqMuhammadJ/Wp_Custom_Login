jQuery(document).ready(function($){
    $('.select-media-button').on('click', function(e){
        e.preventDefault();

        let button = $(this);
        let inputField = button.prev('input[type="text"]');
        let previewImg = button.next('img');

        let frame = wp.media({
            title: 'Select or upload image',
            button: {
                text: "Use this image"
            },
            multiple: false
        });

        frame.on('select', function(){
            const attachment = frame.state().get('selection').first().toJSON();
            inputField.val(attachment.url);

            // If preview image exists, update it
            if (previewImg.length) {
                previewImg.attr('src', attachment.url);
            } else {
                // If no preview image, optionally insert it
                button.after('<img src="' + attachment.url + '" style="max-height:80px; margin-left:10px;" />');
            }
        });

        frame.open();
    });
});
