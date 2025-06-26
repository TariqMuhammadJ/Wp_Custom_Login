jQuery(document).ready(function($){
    let frame;
    $('.select-media-button').on('click', function(e){
        e.preventDefault();
        if(frame){
            frame.open();
            return;
        }

        frame = wp.media({
            title:'Select or upload Logo',
            button: {
                text: "Use this image"
            },
            multiple:false
        });

        frame.on('select', function(){
            const attachment = frame.state().get('selection').first().toJSON();
            $('#custom_login_logo').val(attachment.url);
            $('.custom-image-uploader .preview').html('<img src="' + attachment.url + '" style="max-height:80px;" />');

        });

        frame.open();
    })
})