const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

// Paths to your files
const paths = {
    scss: './blocks/**/*.scss', // SCSS files in the blocks folder
    css: './blocks' // Output folder for compiled CSS
};

// Task to compile SCSS to CSS
gulp.task('styles', function() {
    return gulp.src(paths.scss)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulp.dest(paths.css));
});

// Watch task to automatically recompile on save
gulp.task('watch', function() {
    gulp.watch(paths.scss, gulp.series('styles'));
});

// Default task that runs both the styles and watch tasks
gulp.task('default', gulp.series('styles', 'watch'));
