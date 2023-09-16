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

if ( ! defined( 'ABSPATH' ) ) {
	echo "Ashraf the developer know's what you're doing?";
	exit;
}

class MyContactForm {
	public function __construct() {

		//create custom post type
		add_action( 'init', array( $this, 'create_custom_post' ) );

		//add asets(js, css, etc)
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );

		//add shortcode
		add_shortcode( 'myctform_shortcode', array( $this, 'load_myctform_shortcode' ) );


		//Resigter Rest API
	}

	/**
	 * Prints scripts or data before the closing body tag on the front end.
	 *
	 */
	function wp_footer(): void {
	}

	public function create_custom_post() {

		$args = array(
			'public'               => true,
			'has_archive'          => true,
			'supports'             => array( 'title', 'editor' ),
			'exclude_form_search'  => true,
			'publically_queryable' => true,
			'capability'           => 'manage_options',
			'labels'               => array(
				'name'          => 'My Contat Form',
				'singular_name' => 'Contact Form',
			),
			'menu_icon'            => 'dashicons-media-text',
		);

		register_post_type( 'myctform_post_type', $args );
	}

	public function load_assets() {
		wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );

		wp_enqueue_style(
			'myctform-stylesheet.css',
			plugin_dir_url( __FILE__ ) . 'assets/css/myctform-stylesheet.css',
			[ 'bootstrap' ],
			'all'
		);

		wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array( 'jquery' ), null, true );

		wp_enqueue_script(
			'myctform-script.js',
			plugin_dir_url( __FILE__ ) . 'assets/js/myctform-script.js',
			[ 'jquery' ],
			null,
			true
		);
	}

	public function load_myctform_shortcode() {
		ob_start();
		?>

        <div class="container pt-5">
            <form id="myctform_form" action="">
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
                            <textarea name="msg" placeholder="Write your message" id="msg" class="form-control"
                                      rows="5"></textarea>
                        </div>


                        <button class="btn btn-success btn-block" type="submit" class="btn btn-default">Send Message
                        </button>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>

		<?php
		echo ob_get_clean();
	}

}

//After submit the form this method will fire
function custom_action() {
	$email = $_POST['email'];
	$name  = $_POST['name'];
	$tel   = $_POST['tel'];
	$msg   = $_POST['msg'];
	ob_start();
	?>
    <ul>
        <li>Name : <?php echo $name; ?></li>
        <li>Email : <?php echo $email; ?></li>
        <li>Telephone : <?php echo $tel; ?></li>
        <li>Message : <?php echo $msg; ?></li>
    </ul>
	<?php
	$email_content = ob_get_clean();
	$headers       = array( 'Content-Type: text/html; charset=UTF-8' );
	wp_mail( get_option( 'admin_email' ), 'Contact Form', $email_content, $headers );
	$newPost = wp_insert_post( array(
		'post_type'    => 'myctform_post_type',
		'post_title'   => $name . ' Submit a new Form',
		'post_content' => "Name: $name | Email: $email | Tel: $tel | Msg: $msg",
		'post_status'  => 'publish',
	) );

	echo $newPost;
}

//Custom Hook register called : bisnu_form_submit
add_action( 'wp_ajax_bisnu_form_submit', 'custom_action' );
add_action( 'wp_ajax_nopriv_bisnu_form_submit', 'custom_action' );

new MyContactForm;
