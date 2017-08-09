module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            dist: {
                files: {
                    '../main.css': 'scss/main.scss',
                },
                options: {
                    style: "compressed",
                    sourcemap: "none"
                }
            }
        },
        concat: {
            options: {
                separator: ';\n',
            },
            dist: {
                src: [
                    'js/vendor/**/*.js',
                    'js/main.js',
                    'js/components/**/*.js'
                ],
                dest: '../main.js'
            }
        },
        uglify: {
            options: {
                mangle: {
                    except: []
                }
            },
            my_target: {
                files: {
                    '../main.min.js': ['../main.js']
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass']
            },
            js: {
                files: '**/*.js',
                tasks: ['concat']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('',['sass:dist', 'concat:dist', 'watch']);
    grunt.registerTask('default',['sass:dist', 'concat:dist', 'watch']);
}
