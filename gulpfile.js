var gulp = require('gulp'),	uglify = require('gulp-uglify'),	clean = require('gulp-clean'),	header = require('gulp-header'),	gulpSequence = require('gulp-sequence'), /*保证任务顺序插件*/	versionJolly = require('gulp-jollychic-version');/*自定义版本号生成插件*/var pkg = require('./package.json');var pkgV = require('./version.json');var banner = ['/*!',	' <%= pkg.name %>',	' @version v' + pkgV.version,	' - ' + (new Date()),	' */', '\n'].join('');/*版本号生成*/gulp.task('app_version', function () {	return gulp.src('./version.json')		.pipe(versionJolly())		.pipe(gulp.dest('./'));});/*external seajs目录里面不是cmd规范的模块单独处理*/gulp.task("external", function () {	gulp.src(["./js/*.js", "!./js/min/**"])		.pipe(uglify())		.pipe(header(banner, {pkg: pkg}))		.pipe(gulp.dest("./js/min"));});/*清理*/gulp.task('clean', function () {	return gulp.src(['./js/min'], {read: false})		.pipe(clean());});/*默认*/gulp.task('default', gulpSequence('app_version', 'external', 'clean'));