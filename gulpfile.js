// Base Gulp File
var gulp = require('gulp'),
    concat = require('gulp-concat');
    watch = require('gulp-watch'),
    gutil = require('gulp-util'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    path = require('path'),
    notify = require('gulp-notify'),
    // imagemin = require('gulp-imagemin'),
    cache = require('gulp-cache'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    uglifycss = require('gulp-uglifycss');
    runSequence = require('run-sequence');
    svgmin = require('gulp-svgmin');
    // twig = require('gulp-twig');

// Task to compile SCSS
gulp.task('sass', function () {
    return gulp.src(['assets/src/scss/main.scss',
                     'assets/src/scss/critical.scss'])
        .pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole: false,
            paths: [ path.join(__dirname, 'scss', 'includes') ]
        })
        .on("error", notify.onError(function(error) {
            return "Failed to Compile SCSS: " + error.message;
        })))
        .pipe(autoprefixer())
        .pipe(gutil.env.type === 'production' ? gutil.noop() : sourcemaps.write())
        .pipe(gulp.dest('assets/dist/css/'))
        .pipe(notify("SCSS Compiled Successfully"));
});

// Minify css
gulp.task('cssmin', function () {
    return gulp.src(['assets/dist/css/main.css'])
        .pipe(uglifycss())
        .pipe(concat('main.min.css'))
        .pipe(gulp.dest('assets/dist/css/'));
});

gulp.task('csscriticalmin', function () {
    return gulp.src(['assets/dist/css/critical.css'])
        .pipe(uglifycss())
        .pipe(concat('critical.min.css'))
        .pipe(gulp.dest('assets/dist/css/'));
});

// Configure the jshint task
gulp.task('jshint', function() {
    return gulp.src(['assets/src/js/main.js',
                     'assets/src/js/modules/**/*.js'])
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'));
});

// Task to Minify JS
gulp.task('jsmin', function() {
    gulp.src(['assets/src/js/vendor/**/*.js',
              'assets/src/js/modules/**/*.js',
              'assets/src/js/main.js'])
        .pipe(uglify())
        .pipe(concat('script.js'))
        .pipe(gulp.dest('assets/dist/js/'));
});

gulp.task('svgmin', function() {
    gulp.src('assets/img/**/*.svg')
        .pipe(svgmin())
        .pipe(gulp.dest('assets/img'));
});

// Gulp Watch Task
gulp.task('watch', function () {
    gulp.watch([
        'assets/src/scss/**/*.scss'
    ], ['sass']);
    gulp.watch([
        'assets/src/js/*.js',
        'assets/src/js/modules/**/*.js'
    ], ['jshint']);
    gulp.watch([
      'assets/src/js/**/*.js'
    ], ['jsmin']);
});

// Gulp Default Task
gulp.task('default', ['watch']);

// Gulp Build Task
gulp.task('build', function() {
    runSequence('sass', 'cssmin', 'csscriticalmin', 'jshint', 'jsmin', 'svgmin');
});

// Minify Images
// gulp.task('imagemin', function (){
//     return gulp.src('application/themes/glorious/assets/src/images/**/*.+(png|jpg|jpeg|gif|svg)')
//         // Caching images that ran through imagemin
//         .pipe(cache(imagemin({
//             interlaced: true
//         })))
//         .pipe(gulp.dest('application/themes/glorious/assets/dist/images'));
// });
