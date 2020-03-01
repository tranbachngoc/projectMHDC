var gulp = require('gulp');
var jshint = require('gulp-jshint');
var stylish = require('jshint-stylish');
var runSequence = require('run-sequence');
var gulpLoadPlugins = require('gulp-load-plugins');
var plugins = gulpLoadPlugins();
//const elixir = require('laravel-elixir');
//
//require('laravel-elixir-vue-2');
//
///*
// |--------------------------------------------------------------------------
// | Elixir Asset Management
// |--------------------------------------------------------------------------
// |
// | Elixir provides a clean, fluent API for defining some basic Gulp tasks
// | for your Laravel application. By default, we are compiling the Sass
// | file for our application, as well as publishing vendor resources.
// |
// */
//
//elixir(mix => {
//    mix.sass('app.scss')
//       .webpack('app.js');
//});

gulp.task('lint', function() {
  return gulp.src([
    './public/backend-app/**/*.js'
  ])
  .pipe(jshint())
  .pipe(jshint.reporter(stylish));
});

//TODO - add me
gulp.task('uglify:js', function() {
  var mainView = './resources/views/layouts/scripts.php';
  var appFilter = plugins.filter('**/app/app.js', {restore: true});
  var jsFilter = plugins.filter('**/*.js', {restore: true});
  var cssFilter = plugins.filter('**/*.css', {restore: true});
  var htmlBlock = plugins.filter(['**/*.!(html)'], {restore: true});

  return gulp.src(mainView)
    .pipe(plugins.useref())
      .pipe(appFilter)
        //.pipe(plugins.addSrc.append('.tmp/templates.js'))
        .pipe(plugins.concat('./frontend/app/app.js'))
      .pipe(appFilter.restore)
      .pipe(jsFilter)
        .pipe(plugins.ngAnnotate())
        .pipe(plugins.uglify())
      .pipe(htmlBlock)
      .pipe(htmlBlock.restore)
    .pipe(gulp.dest('./dist'));
});

gulp.task('uglify:css', function() {
  var mainView = './resources/views/layouts/styles.php';
  var cssFilter = plugins.filter('**/*.css', {restore: true});
  var htmlBlock = plugins.filter(['**/*.!(html)'], {restore: true});

  return gulp.src(mainView)
    .pipe(plugins.useref())
      .pipe(cssFilter)
        .pipe(plugins.cleanCss({
            processImportFrom: ['!fonts.googleapis.com']
        }))
    .pipe(gulp.dest('./dist'));
});

gulp.task('copy:fonts', function() {
  return gulp.src([
    './public/fonts/**/*',
    './public/font-awesome/fonts/**/*'
  ], { dot: true })
    .pipe(gulp.dest('./dist/fonts'));
});

gulp.task('uglify', ['uglify:js', 'uglify:css', 'copy:fonts']);

gulp.task('build', function(cb) {
  runSequence([
    'uglify:js',
    'uglify:css', 'copy:fonts'
  ], cb);
});