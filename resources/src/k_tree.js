layui.define(['tree'], function(exports){
    var tree = layui.tree;

    // 树
    $('[data-tree]').each(function (index, el) {
        var settings = $(el).data('tree')
        tree.render({
            elem: '#' + el.id,
            showCheckbox: settings.showCheckbox,
            edit: settings.edit,
            data: settings.data,
        });
    });


    exports('k_tree')
});
