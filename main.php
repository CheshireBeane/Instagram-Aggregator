<?php
/**
 * Plugin Name: Instagram Aggregator
 * Plugin URI: https://cheshirebeane.com
 * Description: Saves Instagram posts as a custom post type
 * Version: 1.0
 * Author: CheshireBeane
 * Author URI: https://cheshirebeane.com
 */



function cheshirebeane_instagram_ui() {
   add_option( 'cb_access_code', '');
   register_setting( 'cb_insta_options_group', 'cb_access_code', 'cb_plugin_callback' );
   add_option( 'cb_frequency', 'off');
   register_setting( 'cb_insta_options_group', 'cb_frequency', 'cb_plugin_callback' );
}
add_action( 'admin_init', 'cheshirebeane_instagram_ui' );

function cheshirebeane_register_options() {
  add_options_page('Page Title', 'Instagram Aggregator', 'manage_options', 'cb_instagram', 'cb_instagram_options_page');
}
add_action('admin_menu', 'cheshirebeane_register_options');


function cb_instagram_options_page()
{
?>

<style media="screen">
  .frequency-area input {
    margin-right: 25px;
  }
</style>

<div>
  <?php screen_icon(); ?>
  <h1>CheshireBeane Instagram Aggregator</h1>
  <form method="post" action="options.php">
    <?php settings_fields( 'cb_insta_options_group' ); ?>
    <h3>Instagram Access Token</h3>
    <p>You can learn about this <a href="https://www.instagram.com/developer/authentication/" target="_blank">here</a></p>
    <table>
      <tr valign="top">
        <td><input type="text" id="cb_access_code" name="cb_access_code" value="<?php echo get_option('cb_access_code'); ?>" style="width: 400px;" placeholder="xxxxxxxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxx"/></td>
      </tr>
    </table>
    <br/>
    <div class="frequency-area">
      <h3>Frequency</h3>
      <p>How often should it check for new Instagram posts</p>
      <?php $options = get_option( 'cb_frequency' ); ?>
      <label for="">Off</label>
      <input type="radio" name="cb_frequency" value="off" <?php checked( 'off' == $options ); ?> />
      <label for="">Hourly</label>
      <input type="radio" name="cb_frequency" value="hourly"<?php checked( 'hourly' == $options ); ?> />
      <label for="">Daily</label>
      <input type="radio" name="cb_frequency" value="daily"<?php checked( 'daily' == $options ); ?> />
      <label for="">Weekly</label>
      <input type="radio" name="cb_frequency" value="weekly"<?php checked( 'weekly' == $options ); ?> />
      <?php submit_button(); ?>
    </div>
  </form>
</div>
<?php
}


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
		"supports" => array( "title", "thumbnail" ),
	);

	register_post_type( "instagram-media", $args );
}

add_action( 'init', 'cheshirebeane_register_instagram_post_type' );


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




function Generate_Featured_Image( $image_url, $post_id  ){
  $upload_dir = wp_upload_dir();
  $image_data = file_get_contents($image_url);
  $filename = basename($image_url);
  if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
  else                                    $file = $upload_dir['basedir'] . '/' . $filename;
  file_put_contents($file, $image_data);

  $wp_filetype = wp_check_filetype($filename, null );
  $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name($filename),
      'post_content' => '',
      'post_status' => 'inherit'
  );
  $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
  $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
  $res2= set_post_thumbnail( $post_id, $attach_id );
}



// create a scheduled event (if it does not exist already)

add_filter( 'cron_schedules', function ( $schedules ) {
    $schedules['every-5-minutes'] = array(
        'interval' => 5 * MINUTE_IN_SECONDS,
        'display'  => __( 'Every minute' )
    );
    return $schedules;
} );

function reset_cb_cron(){
  $freq = get_option( 'cb_frequency' );

  switch ($freq) {
    case $freq == 'off':
        remove_insta_cron();
        break;

    case $freq == 'hourly':
        remove_insta_cron();
        if( !wp_next_scheduled( 'cb_insta_cron' ) ) {
           wp_schedule_event( time(), 'hourly', 'cb_insta_cron' );
        }
        break;

    case $freq == 'daily':
        remove_insta_cron();
        if( !wp_next_scheduled( 'cb_insta_cron' ) ) {
           wp_schedule_event( time(), 'daily', 'cb_insta_cron' );
        }
        break;

    case $freq == 'weekly':
        remove_insta_cron();
        if( !wp_next_scheduled( 'cb_insta_cron' ) ) {
           wp_schedule_event( time(), 'weekly', 'cb_insta_cron' );
        }
        break;

    default:
        remove_insta_cron();
        if( !wp_next_scheduled( 'cb_insta_cron' ) ) {
           wp_schedule_event( time(), 'daily', 'cb_insta_cron' );
        }
    }
}

function cb_start_insta_cron() {
  reset_cb_cron();
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'cb_start_insta_cron');
add_action ( 'cb_insta_cron', 'cheshirebeane_get_instagram_media' );


// uncomment this to view current cron jobs for DEBUGGING
// print_r( _get_cron_array() );


function remove_insta_cron() {
  $timestamp = wp_next_scheduled('cb_insta_cron');
  wp_unschedule_event( $timestamp, 'cb_insta_cron' );
}


function cheshirebeane_get_instagram_media() {
  if(get_option('cb_access_code')) {

    $response = wp_remote_get('https://api.instagram.com/v1/users/self/media/recent/?access_token=' . get_option('cb_access_code') . '' );


    if ( is_array( $response ) && ! is_wp_error( $response ) ) {
      $headers = $response['headers']; // array of http header lines
      $body    = $response['body']; // use the content
      $data    = json_decode($body)->data;

      foreach ($data as $post) {
        $post_title = $post->id;

        if (!post_exists($post_title)) {
          // Create post object
          $my_post = array(
            'post_title'    => $post->id,
            // 'post_author'   => 1,
            'post_type'     => 'instagram-media',
            'post_status'   => 'publish',
            'post_date'     =>  date_i18n('Y/m/d', $post->created_time),
            'meta_input' => array(
              'cb_insta_link' => $post->link,
              'cb_insta_likes' => $post->likes->count,
              'cb_insta_image' => $post->images->standard_resolution->url
            )
          );

          // Insert the post into the database
          wp_insert_post( $my_post );
        }

      }

    }
  } //end if

}

?>
