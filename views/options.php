<?php
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
<?php
}
