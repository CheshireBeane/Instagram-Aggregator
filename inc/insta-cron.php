<?php
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
?>
