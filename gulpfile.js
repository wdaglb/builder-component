/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

const { src, dest, series, watch, parallel } = require('gulp')
const del = require('del')
const babel = require('gulp-babel')
const uglify = require('gulp-uglify')
const sass = require('gulp-sass')
const cssMin = require('gulp-cssmin')
const autoprefixer = require('gulp-autoprefixer')
const sourcemaps = require('gulp-sourcemaps')

sass.compiler = require('dart-sass')

let isDebug = false

const rootPath = 'resources/'
const outputPath = 'dist/'

// clean
const clean = function () {
    return del([
        outputPath
    ])
}

// js资源构建
const js = async function () {
    const pro = src(`${rootPath}src/**/*.js`)
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env']
        }))
    if (!isDebug) {
        pro.pipe(uglify())
    }
    pro.pipe(sourcemaps.write('maps/'))
        .pipe(dest(outputPath))
}

// css资源构建
const css = function () {
    return src(`${rootPath}css/**/*.scss`)
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false,
        }))
        .pipe(cssMin())
        .pipe(dest(`${outputPath}css/`))
}

// 库文件复制
const copyPlugin = function (){
    return src(`${rootPath}static/**/*.*`)
        .pipe(dest(`${outputPath}libs`))
}

const def = series(clean, js, css, copyPlugin)

exports.default = def

exports.watch = async function (cb) {
    isDebug = true
    const opt = { ignoreInitial: false }
    watch(`${rootPath}src/**/*.js`, opt, js)
    watch(`${rootPath}css/**/*.scss`, opt, css)
    watch(`${rootPath}static/**/*.*`, opt, copyPlugin)
    // watch(rootPath, { ignoreInitial: false }, def)
}
