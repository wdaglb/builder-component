"use strict";layui.define(function(t){$("textarea[k-tinymce]").each(function(t,e){var i=JSON.parse(e.getAttribute("k-tinymce"));tinymce.init({target:e,language:i.lang,height:i.height,convert_urls:!1,plugins:"advlist autolink toc link image lists charmap print preview autosave insertdatetime wordcount",images_upload_url:i.image_upload_url})}),t("k_tinymce")});