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
        $subject = 'New Post: ' . $post->post_title;
        $message = 'A new post has been published on your website. View it here: ' . get_permalink( $post_id );
        $recipient = 'dotecodegroup@gmail.com';
        $from = "wisdm@shilavillaresort.com";
        $header = "From: $from";
        if(mail( $recipient, $subject, $message, $header )){
            echo 'done';
        }
        else{
            echo 'error';
        }
    }

    function add_admin_pages() {
        add_menu_page( 'Post Email', 'Post Email', 'manage_options', 'post_email', array( $this, 'admin_page_markup' ), 'dashicons-email-alt', 100 );
    }

    function admin_page_markup() {
        echo "HI";
    }
}

if ( class_exists( 'PostEmail' ) ){
    $cal = new PostEmail();
    $cal->register();
 }


?>