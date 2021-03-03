layui.define(['layer', 'form'], function(exports){
    var layer = layui.layer
        ,form = layui.form;

    // 表单提交
    form.on('submit', function (data) {
        var load = layer.load(data.form)
        var text = $(data.elem).html()
        var reset = function () {
            $(data.elem).attr('disabled', false)
                .removeClass('layui-btn-disabled')
                .html(text)
        }
        $(data.elem).attr('disabled', true)
            .addClass('layui-btn-disabled')
            .html('提交中')

        $.ajax({
            url: '?component_id=' + data.form.id,
            method: 'POST',
            data: data.field,
            complete: function () {
                layer.close(load)
            },
            success: function (res) {
                if (res.code !== 0) {
                    layer.msg(res.msg);
                } else {
                    layer.msg('提交成功');
                }

                // 如果返回url，则2s后跳转
                if (res.url !== undefined) {
                    setTimeout(function () {
                        location.href = res.url;
                    }, 1500);
                } else {
                    reset();
                }
            },
            error: function () {
                reset();
            }
        });
        return false;
    });


    exports('k_form')
});
