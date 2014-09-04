var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var notify = require('gulp-notify');

var phpspecpath = './bin/phpspec run';

gulp.task('test', function() {
    var options = {
        clear: true,
        notify: true
    };

    gulp.src('spec/**/*.php')
        .pipe(phpspec(phpspecpath, options))
        .on('error', notify.onError({
            title: 'Crap!',
            message: 'Your tests failed!'
        }))
        .pipe(notify({
            title:'All good',
            message:'Tests are back to green'
        }));
});

gulp.task('watch', function() {
    gulp.watch(['spec/**/*.php', 'src/**/*.php'], ['test']);
});

gulp.task('default', ['test', 'watch']);
