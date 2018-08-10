<?php
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


          // write to log
          $log_path = ABSPATH . 'wp-content/plugins/cb-instagram/logs/logfile.html';
          $txt = '<p>' . date('m-d-y h:m') . ' - - - - -> New Media Added <a href="' . $post->link . '">' . $post->link . '</a></p>';
          file_put_contents($log_path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
        }



      }

    }
  } //end if

}
?>
