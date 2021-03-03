layui.define(function(exports){

    // tinymce富文本
    $('textarea[k-tinymce]').each(function (index, el) {
        var opt = JSON.parse(el.getAttribute('k-tinymce'))

        tinymce.init({
            target: el,
            language: opt.lang,
            height: opt.height,
            convert_urls: false,
            plugins: 'advlist autolink toc link image lists charmap print preview autosave insertdatetime wordcount',
            // automatic_uploads: false,
            images_upload_url: opt.image_upload_url,
        })
    })

    exports('k_tinymce')
});
