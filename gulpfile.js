/**
 * Modules required
 */
var gulp      = require('gulp');
var gutil     = require('gulp-util');
var uglify    = require('gulp-uglify');
var rename    = require('gulp-rename');
var minifycss = require('gulp-minify-css');
var watch     = require('gulp-watch');

/**
 * Minify CSS files
 */
gulp.task('styles', function() {
    return gulp
        .src(['public/css/*.css', '!public/css/*.min.css'])
        .pipe(minifycss())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/css'));
});

/**
 * Minify JS files
 */
gulp.task('scripts', function() {
    return gulp
        .src(['public/js/*.js', '!public/js/*.min.js'])
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/js'));
});

/**
 * Watcher
 */
gulp.task('watch', function() {
    gulp.watch(['public/js/*.js', '!public/js/*.min.js'], ['scripts']);
    gulp.watch(['public/css/*.css', '!public/css/*.min.css'], ['styles']);
});

gulp.task('default', ['watch']);
