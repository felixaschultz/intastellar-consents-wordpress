jQuery(document).ready(function ($) {
    console.log('Media uploader script loaded');

    var mediaUploader;

    $('#intastellarCustomIconButton').click(function (e) {
        e.preventDefault();
        console.log('Custom Icon Button clicked');

        if (mediaUploader) {
            console.log('Reusing existing media uploader instance');
            mediaUploader.open();
            return;
        }

        console.log('Creating new media uploader instance');
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Logo',
            button: {
                text: 'Choose Logo'
            },
            multiple: false
        });

        mediaUploader.on('open', function () {
            console.log('Media uploader opened');
        });

        mediaUploader.on('close', function () {
            console.log('Media uploader closed');
        });

        mediaUploader.on('error', function (err) {
            console.error('Media uploader error:', err);
        });

        mediaUploader.open();

        mediaUploader.on('select', function () {
            console.log('Media selected');
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            console.log('Selected attachment:', attachment);
            $('#intastellarCustomIcon_id').val(attachment.url);
            $('#intastellarCustomIconPreview').attr('src', attachment.url);
        });
    });
});
