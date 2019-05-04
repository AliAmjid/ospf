var paths = {
	output: {
		js: 'www/js',
		css: 'www/css'
	},

	jsLibs: [
		'node_modules/tether/dist/js/tether.min.js',
		'node_modules/jquery/dist/jquery.js',
		'node_modules/cytoscape/dist/cytoscape.min.js'
	],

	cssLibs: [
	]

};

var fs = require("fs");
var version = fs.readFileSync('www/version', 'utf8', function(err, data) {
	return data;
});

var gulp = require('gulp');
var addsrc = require('gulp-add-src');
var concat = require('gulp-concat');
var ts = require('gulp-typescript');
var uglify = require('gulp-uglify-es').default;
var minifyCSS = require('gulp-minify-css');
var less = require('gulp-less');
var gutil = require('gulp-util');


gulp.task('jsLib', function () {
	gulp.src(paths.jsLibs)
		.pipe(concat("libs-" + version + ".js"))
		.pipe(uglify())
		.on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
		.pipe(gulp.dest('www/js'));
});

gulp.task('cssLib', function () {
	gulp.src(paths.cssLibs)
		.pipe(minifyCSS())
		.pipe(concat("libs-" + version + ".css"))
		.pipe(gulp.dest('www/css'));
});

gulp.task('less', function () {
	gulp.src('build/css/*.less')
		.pipe(less())
		.pipe(minifyCSS())
		.pipe(concat("release-" + version + ".css"))
		.pipe(gulp.dest('www/css'));
});

gulp.task('js', function () {
	gulp.src('build/js/*.js')
		.pipe(concat("release-" + version + ".js"))
		.pipe(uglify())
		.pipe(gulp.dest('www/js'));
});

gulp.task('default',function () {
	gulp.run('jsLib','cssLib','less','js');
});

gulp.task('watch',function () {
	gulp.run('jsLib','cssLib','less','js');
});