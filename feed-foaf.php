<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<rdf:RDF
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:rss="http://purl.org/rss/1.0/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	<?php do_action( 'foaf_ns' ); ?>
>
	<foaf:Document rdf:about="">
		<dc:title>Author list for <?php echo htmlspecialchars( get_bloginfo( 'name' ) ); ?></dc:title>
		<foaf:primaryTopic rdf:nodeID="authors"/>
		<admin:generatorAgent rdf:resource="http://wordpress.org/extend/plugins/simple-foaf/"/>
	</foaf:Document>
	<foaf:Group rdf:nodeID="authors">
		<foaf:name>Authors at <?php echo htmlspecialchars( get_bloginfo( 'name' ) ); ?></foaf:name>
		<foaf:made>
			<foaf:Document rdf:about="<?php echo htmlspecialchars( site_url( '/' ) ); ?>">
				<dc:title><?php echo htmlspecialchars( get_bloginfo( 'name' ) ); ?></dc:title>
				<rdfs:seeAlso>
					<rss:channel rdf:about="<?php echo htmlspecialchars( get_feed_link( 'rss2' ) ); ?>"/>
				</rdfs:seeAlso>
			</foaf:Document>
		</foaf:made>
		<?php
		foreach ( get_users() as $user ) {
			$authordata = get_userdata( $user->ID );
		?>
		<foaf:member>
			<foaf:Person>
				<foaf:firstName><?php echo htmlspecialchars( $authordata->user_firstname ); ?></foaf:firstName>
				<foaf:surname><?php echo htmlspecialchars( $authordata->user_lastname ); ?></foaf:surname>
				<foaf:nick><?php echo htmlspecialchars( $authordata->nickname ); ?></foaf:nick>
				<foaf:email><?php echo $authordata->user_email ?></foaf:email>
				<foaf:weblog rdf:resource="<?php echo htmlspecialchars( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ); ?>"/>
				<rdfs:seeAlso>
					<foaf:PersonalProfileDocument rdf:about="<?php echo htmlspecialchars( get_author_feed_link( $authordata->ID, 'foaf' ) ); ?>"/>
				</rdfs:seeAlso>
			</foaf:Person>
		</foaf:member>
		<?php
		}
		?>
	</foaf:Group>
</rdf:RDF>
