<?php
function init_get_media_callback(){
  if ( ! function_exists( 'post_exists' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/post.php' );
  }
  if(isset($_POST['getmedia'])) {
    cheshirebeane_get_instagram_media();
    ?>

    <?php
  }
}
add_action('init', 'init_get_media_callback');


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
    <br/>
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

<hr/>

    <h2>Get Media On Demand</h2>
    <form method="post" action="">
      <?php
        if(isset($_POST['getmedia'])) {
          ?>
          <div class="updated notice" style="margin-left: 0; margin-bottom: 25px;">
            <p>Successfully received media from Instagram!</p>
          </div>
          <?php
        }
       ?>
         <span id="test-button">

              <input id="test-settings" name="getmedia" type="submit" value="Get Media" class="button" >

         </span>

    </form>
    <br/>
    <h2>Import History</h2>
    <a href="<?php echo home_url() . '/wp-content/plugins/cb-instagram/logs/logfile.html'; ?>" target="_blank">
      <input id="view-logs" name="viewlogs" type="submit" value="View Logs" class="button" />
    </a>
<?php
}
