const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const autoprefixer = require('gulp-autoprefixer');
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const spritesmith = require('gulp.spritesmith');

var config = {
    spriteImgIn: '../images/sprite/*.png',
    spriteAll: '../images/sprite/*',
    spriteImgOut: '../images/sprite-compressed/',
    spriteScssOut: '../scss/global/',
    spriteImgPath: '../images/sprite-compressed/sprite.png',
    spriteImgName: 'sprite.png',
    spriteScssName: '_sprite.scss'
};


gulp.task('sass', () =>
    gulp.src('./../frontend/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(rename('./../public/assets/css/styles.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./../'))
);

gulp.task('sass:watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
});

gulp.task('sprite', function () {
    var spriteData = gulp.src(config.spriteImgIn)
        .pipe(spritesmith({
            imgName: config.spriteImgName,
            cssName: config.spriteScssName,
            imgPath: config.spriteImgPath,
            padding: 2,
            cssVarMap: function(sprite) {
                sprite.name = 'icon-' + sprite.name
            }
        }));
    spriteData.img.pipe(gulp.dest(config.spriteImgOut));
    spriteData.css.pipe(gulp.dest(config.spriteScssOut));
});

gulp.task('build', ['sass']);

gulp.task('watch', () => {
    gulp.watch(config.spriteAll, ['sprite']);
    gulp.watch('./../frontend/scss/**/*.scss', ['sass']);
});