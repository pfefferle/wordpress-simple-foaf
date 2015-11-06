module.exports = function(grunt) {
  // Project configuration.
  grunt.initConfig({
    wp_readme_to_markdown: {
      target: {
        files: {
          'README.md': 'readme.txt'
        },
      },
    },
    wp_deploy: {
      deploy: {
        options: {
          plugin_slug: 'simple-foaf',
          svn_user: 'pfefferle',
          build_dir: './'
        },
      }
    },
    replace: {
      dist: {
        options: {
          patterns: [
            {
              match: /^/,
              replacement: '[![WordPress](https://img.shields.io/wordpress/v/simple-foaf.svg?style=flat-square)](https://wordpress.org/plugins/simple-foaf/) [![WordPress plugin](https://img.shields.io/wordpress/plugin/v/simple-foaf.svg?style=flat-square)](https://wordpress.org/plugins/simple-foaf/changelog/) [![WordPress](https://img.shields.io/wordpress/plugin/dt/simple-foaf.svg?style=flat-square)](https://wordpress.org/plugins/simple-foaf/) \n\n'
            }
          ]
        },
        files: [
          {
            src: ['README.md'],
            dest: './'
          }
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
  grunt.loadNpmTasks('grunt-wp-deploy');
  grunt.loadNpmTasks('grunt-replace');

  // Default task(s).
  grunt.registerTask('default', ['wp_readme_to_markdown', 'replace']);

  // Deploy task(s).
  grunt.registerTask('deploy', ['wp_readme_to_markdown', 'replace', 'wp_deploy']);
};
