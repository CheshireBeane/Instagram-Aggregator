<?php
/**
 * Plugin Name: Instagram Aggregator
 * Plugin URI: https://cheshirebeane.com
 * Description: Saves Instagram posts as a custom post type
 * Version: 1.0
 * Author: CheshireBeane
 * Author URI: https://cheshirebeane.com
 */


// Helpers
require_once dirname( __FILE__ ) .'/lib/helpers.php';

// Instagram CPT
require_once dirname( __FILE__ ) .'/inc/insta-pt.php';

// Instagram CPT meta fields
require_once dirname( __FILE__ ) .'/inc/insta-meta.php';

// Dynamic scheduled tasks
require_once dirname( __FILE__ ) .'/inc/insta-cron.php';

// Dynamic scheduled tasks
require_once dirname( __FILE__ ) .'/inc/aggregator.php';

//Admin Panel UI
require_once dirname( __FILE__ ) .'/views/options.php';

?>
