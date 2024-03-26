module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),
    sass: {
      dist: {
        files: {
          "css/main.css": "scss/styles.scss"
        }
      }
    },
    cssmin: {
      dist: {
        files: {
          "css/main.min.css": "css/main.css"
        }
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      my_target: {
        files: {
          "js/scripts.all.min.js": ["js/plugins.js", "js/main.js"]
        }
      }
    },
    watch: {
      css: {
        files: "**/*.scss",
        tasks: ["sass", "cssmin"],
        options: {
          livereload: true
        }
      },
      html: {
        files: ["**/*.html"],
        options: {
          livereload: true
        }
      }
    }
  });
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.loadNpmTasks("grunt-contrib-cssmin");
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.registerTask("default", ["watch"]);
};
