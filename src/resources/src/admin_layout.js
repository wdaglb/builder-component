/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

layui.define(['layer', 'element'], function(exports){
    const layer = layui.layer
        ,element = layui.element;

    // 选项卡过滤名
    const tabFilter = 'admin-layout-tabs'

    // 父容器宽度
    let containerWidth = $(`[lay-filter="${tabFilter}"]`).width()

    // 选项卡宽度
    let tabsWidth = 0

    // 页码
    let page = 0

    // 总页数
    let pageTotal = 0

    // 是否首页URL
    const isHomeUrl = function (url) {
        return url === undefined || url === '' || url === null || url === '/'
    }

    // 当前焦点选项卡索引
    let tabIdx = -1

    // 已经打开的选项卡
    let tabs = [];

    const menu = $('#admin-layout-menu')

    // 选项卡滚动栏
    const tabEl = $('#admin-layout-tabs .layui-tab-title')

    // 获取tabs宽度
    const getTabWidth = function () {
        const w = $('[lay-filter="admin-layout-tabs"] .layui-tab-title').width()
        tabsWidth = w
    }
    getTabWidth()
    window.onresize = function () {
        getTabWidth()
    }

    const scrollTab = function (left) {
        tabEl.css({
            left: `${left}px`
        })
    }

    // 获取tab宽度
    const setTabWidth = function () {
        const last = tabEl.find('li').eq(tabIdx + 1)
        const lastWidth = last.width()
        const totalWidth = tabEl.width()
        const width = totalWidth - lastWidth
        const pos = last.position()
        pageTotal = Math.ceil(totalWidth / tabsWidth)

        if (pos.left >= containerWidth) {
            scrollTab(containerWidth - (pos.left + lastWidth + 50))
        }

        // console.log('tabs page', pageTotal)
        // if (width <= tabsWidth) {
        //     console.log('ttt')
        // } else {
        //     w.css({
        //         left: `${0-(totalWidth / (page + 1)) / 2}px`
        //     })
        //     console.log('jjj', totalWidth, page, (totalWidth / (page + 1)) / 2)
        // }

        return tabEl
    }

    // 设置url为焦点菜单
    const setCurrentMenu = function (url) {
        menu.find('[target="admin-container"]').parent().removeClass('layui-this')
        menu.find('[href="' + url + '"]').parent().addClass('layui-this')
    }

    // 让第一个tab不可关闭
    $('#admin-layout-tabs .layui-tab-title li:first .layui-tab-close').hide()

    // 翻页点击
    $('.ke-body-tab-icon').on('click', function () {
        if (tabsWidth <= containerWidth) {
            return
        }
        let left = tabEl.position().left
        if ($(this).hasClass('ke-body-tab-prev')) {
            left = left + containerWidth
            if (left === containerWidth) {
                return
            }
            if (left > 0) {
                left = 0
            }
            scrollTab(left)
        } else if ($(this).hasClass('ke-body-tab-next')) {
            if (tabsWidth < containerWidth) {
                return
            }
            const last = tabEl.find('li:last')
            left = left - last.width()
            if (left < containerWidth) {
                left = left - containerWidth
            } else {
                left = tabsWidth + left
            }
            const jleft = (last.position().left - containerWidth + last.width() + 50)
            if (left < 0 - (tabsWidth - containerWidth)) {
                // 获取最后一个元素
                left = 0 - (jleft)
            }
            scrollTab(left)
        }
        // setTabWidth()
    })

    // 滚动到焦点tab
    const scrollActiveTab = function () {
        const tab = $(`[lay-filter="${tabFilter}"]`)
        const tabOffset = tab.offset()
        const tabRight = tabOffset.left + tab.width()
        // 取焦点位置
        const activeTab = tabEl.find('li').eq(tabIdx + 1)
        const offsetTab = activeTab.offset()
        if (offsetTab.left < tabOffset.left) {
            setTabWidth()
        } else if (offsetTab.left + activeTab.width() > tabRight) {
            setTabWidth()
        }
    }

    // 监听选项卡切换
    element.on('tab(' + tabFilter + ')', function (data) {
        const idx = data.index - 1
        if (idx === -1) {
            tabIdx = -1
            $('.ke-tab-item.itemed').removeClass('itemed')
            $('.ke-tab-item:first').addClass('itemed')

            const query = getUrlQuery()
            if (query.title) {
                delete query.title
            }
            history.pushState(null, null, location.pathname + queryToString(query))
            setCurrentMenu('/')
            scrollActiveTab()
            return
        }
        if (tabs[idx] && tabIdx !== idx) {
            tabIdx = idx
            tabs[idx].switch()
            scrollActiveTab()
        }
    })

    // 监听选项卡删除
    element.on('tabDelete(' + tabFilter + ')', function (data) {
        const idx = data.index - 1
        if (idx === -1) {
            return
        }
        tabs[idx].close()
    })

    // 创建tab
    const createTab = function (url, title) {
        let isHome = isHomeUrl(url)

        const iframe = $('.ke-tab-item:last').removeClass('itemed').clone()
        iframe.find('iframe').attr('src', url).attr('id', url)
        iframe.addClass('itemed')

        $('.ke-tab-content').append(iframe)

        const tab = {
            url: url,
            title: title,
            iframe: iframe,
            switch: function() {
                element.tabChange(tabFilter, url)
                $('.ke-tab-item').removeClass('itemed')
                iframe.addClass('itemed')
                const query = queryToString({ title: title })

                if (isHome) {
                    history.pushState(null, null, location.pathname + location.search)
                } else {
                    history.pushState(null, null, location.pathname + query + '#' + url)
                }
                setCurrentMenu(url)
            },
            close: function () {
                const idx = tabs.findIndex(item => item.url === url)
                element.tabDelete(tabFilter, url)
                iframe.remove()
                if (idx > -1) {
                    tabs.splice(idx, 1)
                }
                getTabWidth()
            }
        }

        tabs.push(tab)

        element.tabAdd(tabFilter, {
            title: title,
            id: url
        })
        element.tabChange(tabFilter, url)

        getTabWidth()

        return tab
    }

    // 获取url对应的tab
    // 不存在返回-1, -2是首页
    const getMatchTab = function (url) {
        if (isHomeUrl(url)) {
            return -2
        }
        for (let i = 0; i < tabs.length; i++) {
            if (tabs[i].url === url) {
                return tabs[i]
            }
        }
        return -1
    }

    // 展开父级
    const setItemedMenu = function (that) {
        that.parents('.layui-nav-item').addClass('layui-nav-itemed')
    }

    // iframe加载
    const setIframeUrl = function (uri, title) {
        let url = uri.trim()
        if (url.substr(0, 1) !== '/' || url.substr(0, 2) === '//') {
            return
        }
        // 获取标题
        if (title === '' || title === undefined || title === null) {
            title = menu.find('[href="' + url + '"]').text()
        }
        const query = getUrlQuery()
        if (title === '' || title === undefined || title === null) {
            title = query.title
        }
        query.title = title

        let tab = getMatchTab(url)
        if (tab !== -1 && tab !== -2) {
            tab.switch()
        } else if(tab !== -2) {
            tab = createTab(url, title)
        } else {
            // 首页
            element.tabChange(tabFilter, '/')
        }
        const queryString = queryToString(query)

        if (url === undefined || url === '' || url === null || url === '/') {
            history.pushState(null, null, location.pathname + queryString)
        } else {
            history.pushState(null, null, location.pathname + queryString + '#' + url)
        }
    }

    // 加载当前焦点菜单
    const loadCurrentMenu = function () {
        let hash = location.hash
        if (hash) {
            hash = hash.substr(1)

            const that = menu.find('[href="' + hash + '"]')
            setItemedMenu(that)
            setIframeUrl(hash)
        }
    }

    // 后台布局头部
    $('[lay-filter="top-header-right"] a').on('click', function () {
        const url = $(this).attr('href')
        const title = $(this).text()
        $(this).parent().removeClass('layui-this')
        setIframeUrl(url, title)
        console.log('nav', url, title)
        return false
    })

    // 侧栏点击
    menu.on('click', '[target="admin-container"]', function () {
        const url = $(this).attr('href')

        setIframeUrl(url)
        return false
    })

    // 导航切换
    $('[lay-filter="admin-layout-tabs-nav"] [event]').on('click', function () {
        const event = $(this).attr('event')
        $(this).parent().removeClass('layui-this')

        switch (event) {
            case 'closeCurrent':
                if (tabIdx === -1) {
                    return
                }
                tabs[tabIdx].close()
                break
            case 'closeOther':
                const tab = { ...tabs[tabIdx] }
                tabEl.find('li').each((idx, el) => {
                    const id = $(el).attr('lay-id')
                    if (id !== '/' && id !== tab.url) {
                        $(el).remove()
                        $(`.ke-body [id="${id}"]`).parent().remove()
                    }
                })
                tabs = [ { ...tab } ]
                tabIdx = 0
                scrollTab(0)

                break
            case 'closeAll':
                tabEl.find('li').each((idx, el) => {
                    const id = $(el).attr('lay-id')
                    if (id !== '/') {
                        $(el).remove()
                        $(`.ke-body [id="${id}"]`).parent().remove()
                    }
                })
                tabs = []
                tabIdx = -1
                scrollTab(0)

                element.tabChange(tabFilter, '/')

                break
        }
    })

    loadCurrentMenu()

    setTabWidth()

    exports('admin_layout')
});
