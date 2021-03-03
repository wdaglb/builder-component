/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

/**
 * 获取query参数
 * @returns {{}}
 */
function getUrlQuery() {
    if (!location.search) return {}
    const search = location.search.substr(1)
    const obj = {}
    const temps = search.split('&')
    for (let i = 0; i < temps.length; i++) {
        const temp = temps[i].split('=')
        obj[temp[0]] = window.decodeURIComponent(temp[1])
    }
    return obj
}

function queryToString(query) {
    if (!query) return ''
    let str = '?'
    for (let key in query) {
        str += key + '=' + window.encodeURIComponent(query[key])
    }
    if (str === '?') {
        return ''
    }

    return str
}
