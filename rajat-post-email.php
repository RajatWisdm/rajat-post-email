<?php
/*
 * Plugin Name:       Post Email
 * Plugin URI:        https://github.com/plugins/the-basics/
 * Description:       This is a simple wordpress plugin that will help users schedule their post in advance
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rajat Ganguly
 * Author URI:        https://github.com/RajatWisdm/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

class PostEmail{
    public $plugin;

    function __construct() {
        $this->plugin = plugin_basename( __FILE__ );
    }
    
    function register() {
        // ADDING ADMIN PAGE
        add_action( 'admin_menu', [ $this, 'add_admin_pages' ] );

        // add_action( 'draft_to_publish', [ $this, 'send_email' ] );
        add_action( 'publish_post', [ $this, 'send_email' ] );
    }

    function send_email( $post_id ) {
        $post = get_post( $post_id );

        // $url = get_permalink( $post_id ); // Due to configuration overlapping only the home page url is taken, in production level this line should be used instead of the next line
        $url = "https://shilavillaresort.com/wisdm"; 
        $key = 'Idontwannashowyoumykey'; //Google PageSpeed API key
        // https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&key=$key
        $api_url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://shilavillaresort.com/wisdm&key=AIzaSyBf8czo8hCJtqdckFaHLKjvVqGSj7EGWog";

        $data = file_get_contents($api_url);
        $results = json_decode($data, true);

        $score = $results['lighthouseResult']['categories']['performance']['score'] * 100;

        // echo "Google PageSpeed score for $url: $score";

        $subject = 'New Post: ' . $post->post_title;
        $message = "Post Title: $post->post_title\n
        Post URL: ". get_permalink( $post_id )."\n
        Meta Title: ".print_r(get_post_meta( $post_id, '', true ))."\n
        Meta Description: ".get_post_meta( $post_id )."\n
        Meta keyword: ".get_post_meta( $post_id )."\n
        Google page speed score: ". $score."\n
        " . get_permalink( $post_id );
        $recipient = get_bloginfo('admin_email');
        $from = "wisdm@shilavillaresort.com";
        $header = "From: $from";
        if(mail( $recipient, $subject, $message, $header )){
            echo 'done';
        }
        else{
            mail( $recipient, $subject, "error", $header );
        }
    }

    function add_admin_pages() {
        add_menu_page( 'Post Email', 'Post Email', 'manage_options', 'post_email', array( $this, 'admin_page_markup' ), 'dashicons-email-alt', 100 );
    }

    function admin_page_markup() {
        require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
    }
}

if ( class_exists( 'PostEmail' ) ){
    $cal = new PostEmail();
    $cal->register();
 }

//  <!-- Plugin123@
// wisdm@shilavillaresort.com -->


?>