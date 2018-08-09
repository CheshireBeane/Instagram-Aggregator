<?php
function cheshirebeane_register_instagram_post_type() {

	/**
	 * Post Type: Instagram Media.
	 */

	$labels = array(
		"name" => __( "Instagram Media", "cb_neat" ),
		"singular_name" => __( "Instagram Media", "cb_neat" ),
	);

	$args = array(
		"label" => __( "Instagram Media", "cb_neat" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "instagram-media",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"query_var" => true,
		"menu_icon" => 'dashicons-camera',
		"supports" => array( "title", "thumbnail" ),
	);

	register_post_type( "instagram-media", $args );
}

add_action( 'init', 'cheshirebeane_register_instagram_post_type' );

?>
