"use strict";function ownKeys(e,t){var n,i=Object.keys(e);return Object.getOwnPropertySymbols&&(n=Object.getOwnPropertySymbols(e),t&&(n=n.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),i.push.apply(i,n)),i}function _objectSpread(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?ownKeys(Object(n),!0).forEach(function(t){_defineProperty(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):ownKeys(Object(n)).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}function _defineProperty(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}layui.define(["layer","element"],function(t){layui.layer;function r(t){return void 0===t||""===t||null===t||"/"===t}function l(){var t=$('[lay-filter="admin-layout-tabs"] .layui-tab-title').width();a=t}var o=layui.element,s="admin-layout-tabs",i=$('[lay-filter="'.concat(s,'"]')).width(),a=0,u=-1,c=[],f=$("#admin-layout-menu"),d=$("#admin-layout-tabs .layui-tab-title");l(),window.onresize=function(){l()};function h(t){d.css({left:"".concat(t,"px")})}function y(){var t=(n=d.find("li").eq(u+1)).width(),e=d.width(),n=n.position();return Math.ceil(e/a),n.left>=i&&h(i-(n.left+t+50)),d}function b(t){f.find('[target="admin-container"]').parent().removeClass("layui-this"),f.find('[href="'+t+'"]').parent().addClass("layui-this")}$("#admin-layout-tabs .layui-tab-title li:first .layui-tab-close").hide(),$(".ke-body-tab-icon").on("click",function(){var t,e;a<=i||(t=d.position().left,$(this).hasClass("ke-body-tab-prev")?(t+=i)!==i&&h(t=0<t?0:t):$(this).hasClass("ke-body-tab-next")&&(a<i||((t-=(e=d.find("li:last")).width())<i?t-=i:t=a+t,e=e.position().left-i+e.width()+50,h(t=t<0-(a-i)?0-e:t))))});function n(){var t=$('[lay-filter="'.concat(s,'"]')),e=t.offset(),n=e.left+t.width(),i=d.find("li").eq(u+1);((t=i.offset()).left<e.left||t.left+i.width()>n)&&y()}o.on("tab("+s+")",function(t){var e=t.index-1;if(-1==e){u=-1,$(".ke-tab-item.itemed").removeClass("itemed"),$(".ke-tab-item:first").addClass("itemed");t=getUrlQuery();return t.title&&delete t.title,history.pushState(null,null,location.pathname+queryToString(t)),b("/"),void n()}c[e]&&u!==e&&(c[u=e].switch(),n())}),o.on("tabDelete("+s+")",function(t){t=t.index-1;-1!=t&&c[t].close()});function m(t,e){var n,i=t.trim();"/"===i.substr(0,1)&&"//"!==i.substr(0,2)&&(""!==e&&null!=e||(e=f.find('[href="'+i+'"]').text()),n=getUrlQuery(),""!==e&&null!=e||(e=n.title),n.title=e,-1!==(t=function(t){if(r(t))return-2;for(var e=0;e<c.length;e++)if(c[e].url===t)return c[e];return-1}(i))&&-2!==t?t.switch():-2!==t?t=function(e,n){var i=r(e),a=$(".ke-tab-item:last").removeClass("itemed").clone();a.find("iframe").attr("src",e).attr("id",e),a.addClass("itemed"),$(".ke-tab-content").append(a);var t={url:e,title:n,iframe:a,switch:function(){o.tabChange(s,e),$(".ke-tab-item").removeClass("itemed"),a.addClass("itemed");var t=queryToString({title:n});i?history.pushState(null,null,location.pathname+location.search):history.pushState(null,null,location.pathname+t+"#"+e),b(e)},close:function(){var t=c.findIndex(function(t){return t.url===e});o.tabDelete(s,e),a.remove(),-1<t&&c.splice(t,1),l()}};return c.push(t),o.tabAdd(s,{title:n,id:e}),o.tabChange(s,e),l(),t}(i,e):o.tabChange(s,"/"),n=queryToString(n),void 0===i||""===i||null===i||"/"===i?history.pushState(null,null,location.pathname+n):history.pushState(null,null,location.pathname+n+"#"+i))}var e;$('[lay-filter="top-header-right"] a').on("click",function(){var t=$(this).attr("href"),e=$(this).text();return $(this).parent().removeClass("layui-this"),m(t,e),console.log("nav",t,e),!1}),f.on("click",'[target="admin-container"]',function(){var t=$(this).attr("href");return m(t),!1}),$('[lay-filter="admin-layout-tabs-nav"] [event]').on("click",function(){var t=$(this).attr("event");switch($(this).parent().removeClass("layui-this"),t){case"closeCurrent":if(-1===u)return;c[u].close();break;case"closeOther":var i=_objectSpread({},c[u]);d.find("li").each(function(t,e){var n=$(e).attr("lay-id");"/"!==n&&n!==i.url&&($(e).remove(),$('.ke-body [id="'.concat(n,'"]')).parent().remove())}),c=[_objectSpread({},i)],h(u=0);break;case"closeAll":d.find("li").each(function(t,e){var n=$(e).attr("lay-id");"/"!==n&&($(e).remove(),$('.ke-body [id="'.concat(n,'"]')).parent().remove())}),c=[],u=-1,h(0),o.tabChange(s,"/")}}),(e=location.hash)&&(e=e.substr(1),f.find('[href="'+e+'"]').parents(".layui-nav-item").addClass("layui-nav-itemed"),m(e)),y(),t("admin_layout")});