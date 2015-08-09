<?php
/*
Plugin Name: SimpleFOAF
Plugin URI: http://notizblog.org/
Description: FOAF RDF/XML profile.
Version: 1.0.0
Author: Matthias Pfefferle
Author URI: http://notizblog.org/
*/

// based on the great work of http://www.wasab.dk/morten/blog/archives/2004/07/05/wordpress-plugin-foaf-output?version=1.17

add_action( 'init', array( 'SimpleFoafPlugin', 'init' ) );
register_activation_hook( __FILE__, array( 'SimpleFoafPlugin', 'flush_rewrite_rules' ) );
register_deactivation_hook( __FILE__, array( 'SimpleFoafPlugin', 'flush_rewrite_rules' ) );

class SimpleFoafPlugin {

	/**
	 * init function
	 */
	function init() {
		add_action( 'wp_head', array( 'SimpleFoafPlugin', 'add_header' ) );
		add_filter( 'host_meta', array( 'SimpleFoafPlugin', 'add_host_meta_links' ) );
		add_filter( 'webfinger_user_data', array( 'SimpleFoafPlugin', 'add_webfinger_links' ), 10, 3 );

		// add 'foaf' as feed
		add_action( 'do_feed_foaf', array( 'SimpleFoafPlugin', 'do_feed_foaf' ) );

		add_feed( 'foaf', array( 'SimpleFoafPlugin', 'do_feed_foaf' ) );
	}

	/**
	 * reset rewrite rules
	 */
	function flush_rewrite_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	/**
	 * add link headers
	 */
	function add_header() {
		if ( is_home() ) {
?>
	<link rel="meta" type="application/rdf+xml" title="FOAF" href="<?php echo get_feed_link( 'foaf' ); ?>" />
<?php
		} elseif ( is_author() ) {
			if ( get_query_var( 'author_name' ) ) {
				$authordata = get_user_by( 'slug', get_query_var( 'author_name' ) );
			} else {
				$authordata = get_userdata( get_query_var( 'author' ) );
			}
?>
	<link rel="meta" type="application/rdf+xml" title="FOAF" href="<?php echo get_author_feed_link( $authordata->ID, 'foaf' ); ?>" />
<?php
		}
	}

	/**
	 * handles new feed type
	 */
	function do_feed_foaf() {
		header( 'Content-type: application/rdf+xml' );

		if ( is_author() ) {
			load_template( dirname( __FILE__ ) . '/feed-foaf-author.php' );
		} else {
			load_template( dirname( __FILE__ ) . '/feed-foaf.php' );
		}
	}

	/**
	 * add the host meta information
	 */
	function add_host_meta_links($host_meta) {
		$host_meta['links'][] = array( 'rel' => 'describedby', 'href' => get_feed_link( 'foaf' ), 'type' => 'application/rdf+xml' );

		return $host_meta;
	}

	/**
	 * add the host meta information
	 */
	function add_webfinger_links($webfinger, $resource, $user) {
		$webfinger['links'][] = array( 'rel' => 'describedby', 'href' => get_author_feed_link( $user->ID, 'foaf' ), 'type' => 'application/rdf+xml' );

		return $webfinger;
	}
}
