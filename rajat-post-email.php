<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/RajatWisdm/
 * @since             1.0.0
 * @package           Rajat_Post_Email
 *
 * @wordpress-plugin
 * Plugin Name:       Rajat Post Email
 * Plugin URI:        https://https://github.com/RajatWisdm/rajat-post-email
 * Description:       This wordpress plugin sends you details of daily post updates
 * Version:           1.0.0
 * Author:            Rajat Ganguly
 * Author URI:        https://https://github.com/RajatWisdm/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rajat-post-email
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RAJAT_POST_EMAIL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rajat-post-email-activator.php
 */
function activate_rajat_post_email() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rajat-post-email-activator.php';
	Rajat_Post_Email_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rajat-post-email-deactivator.php
 */
function deactivate_rajat_post_email() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rajat-post-email-deactivator.php';
	Rajat_Post_Email_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rajat_post_email' );
register_deactivation_hook( __FILE__, 'deactivate_rajat_post_email' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rajat-post-email.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

// class PostEmail{
//     public $plugin;

//     function __construct() {
//         $this->plugin = plugin_basename( __FILE__ );
//     }
    
//     function register() {
//         // ADDING ADMIN PAGE
//         add_action( 'admin_menu', [ $this, 'add_admin_pages' ] );

//         // add_action( 'draft_to_publish', [ $this, 'send_email' ] );
//         add_action( 'publish_post', [ $this, 'send_email' ] );
//     }

//     function get_speed_test_result( $post_id ){
//         $url = get_permalink( $post_id ); 
//         $key = '416ca0ef-63e4-4caa-a047-ead672ecc874'; //Google PageSpeed API key
//         // https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&key=$key
//         $api_url = "http://www.webpagetest.org/runtest.php?url=".$url."&runs=1&f=xml&k=".$key;

//         $run_result = simplexml_load_file($api_url);
// 	    $test_id = $run_result->data->testId;

//         sleep(50);
//         $xml_result = "http://www.webpagetest.org/xmlResult/" . $test_id . "/";
//         $result = simplexml_load_file($xml_result);
//         $status_code = $result->statusCode;
//         $time = (float) ($result->data->median->firstView->loadTime) / 1000;
//         return $time;
//     }

//     // add_action( 'wp', 'schedule_daily_posts_email' );
//         function schedule_daily_posts_email() {
//             if ( ! wp_next_scheduled( 'send_email' ) ) {
//                 wp_schedule_event( strtotime( 'today 10:10am' ), 'daily', 'send_email' );
//             }
//         }
   
// // add_action( 'send_email', 'send_email' );

//     function send_email( $post_id ) {
//         $post = get_post( $post_id );

//         $score = $this->get_speed_test_result( $post_id );

//         // echo "Google PageSpeed score for $url: $score";

//         $subject = 'New Post: ' . $post->post_title;
//         $message = "Post Title: $post->post_title\n
//         Post URL: ". get_permalink( $post_id )."\n
//         Meta Title: ".print_r(get_post_meta( $post_id, '', true ))."\n
//         Meta Description: ".get_post_meta( $post_id )."\n
//         Meta keyword: ".get_post_meta( $post_id )."\n
//         Page speed score: ". $score."\n
//         " . get_permalink( $post_id );
//         $recipient = get_bloginfo('admin_email');
//         if ( get_option( 'post_email_user' ) ){
//             $recipient = get_option( 'post_email_user' );
//         }
//         $from = "wisdm@shilavillaresort.com";
//         $header = "From: $from";
//         if(mail( $recipient, $subject, $message, $header )){
//             echo 'done';
//         }
//         else{
//             mail( $recipient, $subject, "error", $header );
//         }
//     }

//     function add_admin_pages() {
//         add_menu_page( 'Post Email', 'Post Email', 'manage_options', 'post_email', array( $this, 'admin_page_markup' ), 'dashicons-email-alt', 100 );
//     }

//     function admin_page_markup() {
//         require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
//     }
// }

// if ( class_exists( 'PostEmail' ) ){
//     $cal = new PostEmail();
//     $cal->register();
//  }
add_action( 'wp', 'wdm_schedule_mail' );
function wdm_schedule_mail() {
    if ( ! wp_next_scheduled( 'send_email' ) ) {
        wp_schedule_event( strtotime( 'today 10:10pm' ), 'daily', 'send_email' );
    }
}
   
add_action( 'send_email', 'send_email' );
   
   
function send_email() {
    $args = array('post_type' => 'post','post_status' => 'publish','posts_per_page' => -1,'date_query' => array(array('year' => date( 'Y' ),'month' => date( 'm' ),'day' => date( 'd' ))));
    $posts = get_posts( $args );

    
    // Create email message
    $message = "Here are your results of ".date("Y/m/d").":" ;
    foreach ( $posts as $post ) {

        $score = get_speed_test_result( $post->ID );

        // echo "Google PageSpeed score for $url: $score";

        $subject = 'New Post: ' . $post->post_title;
        $message = "Post Title: $post->post_title\n
        Post URL: ". get_permalink( $post->ID )."\n
        Meta Title: ".print_r(get_post_meta( $post->ID, '', true ))."\n
        Meta Description: ".get_post_meta( $post->ID )."\n
        Meta keyword: ".get_post_meta( $post->ID )."\n
        Page speed score: ". $score."\n
        " . get_permalink( $post->ID );
        $recipient = get_bloginfo('admin_email');
        if ( get_option( 'post_email_user' ) ){
            $recipient = get_option( 'post_email_user' );
        }
        $from = "wisdm@shilavillaresort.com";
        $header = "From: $from";
        if(mail( $recipient, $subject, $message, $header )){
            echo 'done';
        }
        else{
            mail( $recipient, $subject, "error", $header );
        }


        $message .= $post->post_title . " (ID: " . $post->ID . ")\r\n";
        $url = get_permalink($post);

        $message.="Meta URl ".$url."\r\n";

        $response = wp_remote_retrieve_body(wp_remote_get($url));
        $meta_desc = wdm_get_meta_desc($response);
        $meta_title = wdm_meta_title($response);
        
        $message.="Meta Description ".$meta_desc."\r\n";
        $message.="Meta Title ".$meta_title."\r\n";
        $message.="Page Speed Score ".get_page_speed_score($url)."\r\n";
    }
       
    // Send email
    wp_mail( get_option( 'admin_email' ), 'Daily Posts', $message );
}
   
add_action('publish_post','send_email');

function get_speed_test_result( $post_id ){
        $url = get_permalink( $post_id ); 
        $key = '416ca0ef-63e4-4caa-a047-ead672ecc874'; //Google PageSpeed API key
        // https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&key=$key
        $api_url = "http://www.webpagetest.org/runtest.php?url=".$url."&runs=1&f=xml&k=".$key;

        $run_result = simplexml_load_file($api_url);
	    $test_id = $run_result->data->testId;

        sleep(50);
        $xml_result = "http://www.webpagetest.org/xmlResult/" . $test_id . "/";
        $result = simplexml_load_file($xml_result);
        $sc = (float) ($result->data->median->firstView->loadTime) / 1000;
        return $sc;
    }

function wdm_get_meta_desc($res)
{
    $word = '<meta name="description" content="';

    $index = strpos($res, $word);
    $metaDescriptionMsg = '';

    if ($index !== false) {
        $end = strpos($res, '>', $index);
        $start = $index + 34;
        $length = $end - $start - 3;
        $metaDescriptionMsg = substr($res, $start, $length);
    } else {
        $metaDescriptionMsg = "No Meta Description Found";
    }
    return $metaDescriptionMsg;

}
   
function wdm_meta_title($htmlResponse)
{
    $word = '<title>';
    $index = strpos($htmlResponse, $word);
    $metaTitle = '';
    if ($index !== false) {
        $end = strpos($htmlResponse, '</title>', $index);
        $start = $index + 7;
        $length = $end - $start;
        $metaTitle = substr($htmlResponse, $start, $length);
    } else {
        $metaTitle = "No Title Found";
    }

    return $metaTitle;
}