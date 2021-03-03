layui.define(function(exports){
    const initEcharts = function (elem, options) {
        const chart = echarts.init(elem)
        chart.setOption(options)
    }

    if (componentOptions.echarts) {
        for (let componentId in componentOptions.echarts) {
            const el = document.getElementById(componentId)
            initEcharts(el, componentOptions.echarts[componentId])
        }
    }

    exports('k_echarts')
});
