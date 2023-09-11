<?php
/*
 * Plugin Name:       My Contact Form
 * Plugin URI:        https://github.com/ashrafbd1496/my-contact-form
 * Description:       My Simple Contact Form
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Md Ashraf Uddin
 * Author URI:        https://ashrafbd.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/ashrafbd1496/plugin-dev
 * Text Domain:       myctform
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    echo "Ashraf the developer know's what you're doing?";
    exit;
}

class MyContactForm
{
    public function __construct()
    {

        //create custom post type
        add_action('init', array($this, 'create_custom_post'));

        //add asets(js, css, etc)
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        //add shortcode
        add_shortcode('myctform_shortcode', array($this, 'load_myctform_shortcode'));
    }
    public function create_custom_post()
    {

        $args = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'exclude_form_search' => true,
            'publically_queryable' => false,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'My Contat Form',
                'singular_name' => 'Contact Form',
            ),
            'menu_icon' => 'dashicons-media-text',
        );

        register_post_type('myctform_post_type', $args);
    }

    public function load_assets()
    {
        wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

        wp_enqueue_style(
            'myctform-stylesheet.css',
            plugin_dir_url(__FILE__) . 'assets/css/myctform-stylesheet.css',
            [],
            'all'
        );

        wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);

        wp_enqueue_script(
            'myctform-script.js',
            plugin_dir_url(__FILE__) . 'assets/js/myctform-script.js',
            ['jquery'],
            null,
            true
        );
    }

    public function load_myctform_shortcode()
    { ?>

        <div class="container">
            <form id="myctform_form" action="/">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">

                        <h2>Send us an email</h2>
                        <p>Please fill the bellow form</p>


                        <div class="form-group mb-2">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                        </div>

                        <div class="form-group mb-2">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>

                        <div class="form-group mb-2">
                            <label for="tel">Phone:</label>
                            <input type="tel" class="form-control" id="tel" placeholder="Enter Phone Number" name="tel">
                        </div>
                        <div class="form-group mb-2">
                            <textarea name="msg" placeholder="Write your message" id="msg" class="form-control"></textarea>
                        </div>


                        <button class="btn btn-success btn-block" type="submit" class="btn btn-default">Send Message</button>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>

<?php }
}
new MyContactForm;
