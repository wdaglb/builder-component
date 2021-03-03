layui.define(['layer', 'table'], function(exports){
    var layer = layui.layer
        ,table = layui.table;

    console.log('hjkalsd')
    //
    // $(document).on('[pjax]', '#admin-container')

    // $(document).on('ready pjax:end', function(event) {
    //     console.log('form render')
    //     form.render()
    // })

    // 表格
    $('table').each(function (index, el) {
        table.init($(el).attr('lay-filter'));
    });

    exports('k_table')
});
