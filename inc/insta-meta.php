<?php
function cheshirebeane_instagram_metaboxes() {
	add_meta_box(
		'cb_insta_image',
		'Image Url',
		'cb_insta_image',
		'instagram-media',
		'normal',
		'default'
	);
	add_meta_box(
		'cb_insta_link',
		'Link',
		'cb_insta_link',
		'instagram-media',
		'normal',
		'default'
	);
	add_meta_box(
		'cb_insta_likes',
		'Likes',
		'cb_insta_likes',
		'instagram-media',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes_instagram-media', 'cheshirebeane_instagram_metaboxes' );


function cb_insta_image() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'cb_insta_image' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'cb_insta_image', true );
	// Output the field
	echo '<input type="text" name="image" value="' . esc_textarea( $location )  . '" class="widefat">';
}
function cb_insta_link() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'cb_insta_link' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'cb_insta_link', true );
	// Output the field
	echo '<input type="text" name="link" value="' . esc_textarea( $location )  . '" class="widefat">';
}
function cb_insta_likes() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'cb_insta_likes' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'cb_insta_likes', true );
	// Output the field
	echo '<input type="text" name="likes" value="' . esc_textarea( $location )  . '" class="widefat">';
}


function cheshirebeane_save_instagram_media_metaboxes( $post_id ){
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}


	//UPLOAD FIELDS
	if ( isset( $_REQUEST['image'] ) ) {
		update_post_meta( $post_id, 'cb_insta_image', sanitize_text_field( $_POST['image'] ) );
	}

	if ( isset( $_REQUEST['link'] ) ) {
		update_post_meta( $post_id, 'cb_insta_link', sanitize_text_field( $_POST['link'] ) );
	}

	if ( isset( $_REQUEST['likes'] ) ) {
		update_post_meta( $post_id, 'cb_insta_likes', sanitize_text_field( $_POST['likes'] ) );
	}

}
add_action( 'save_post', 'cheshirebeane_save_instagram_media_metaboxes', 10, 2 );

?>
