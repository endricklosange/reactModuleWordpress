<?php 
/**
 * Plugin Name: React Example
 */
defined( 'ABSPATH' ) || die();

// In main plugin file
register_activation_hook( __FILE__, 'example_react_activation' );
require_once("api/create.php");
require_once("api/getAll.php");
require_once("api/get.php");

/**
 * Function to create necessary database tables upon plugin activation.
 */
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', "/wp-content/plugins/react-exemple/assets/js/custom-script.js", array('jquery'), '1.0', true);

    // Passer les données PHP à votre script JavaScript
    wp_localize_script('custom-script', 'wpApiSettings', array(
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

function ajouter_avant_body()
{
    echo '
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" href="/wp-content/plugins/react-exemple/assets/css/splide.min.css">
<link rel="stylesheet" href="/wp-content/plugins/react-exemple/assets/css/ImageSlider.css">

';
}
add_action('wp_footer', 'ajouter_avant_body');
function example_react_activation() {
    global $wpdb;
            $table_name = $wpdb->prefix . 'produit_search'; 
            if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {

                $sql = "CREATE TABLE $table_name (
                    produit_id INT AUTO_INCREMENT PRIMARY KEY,
                    genre VARCHAR(255),
                    parentcategorie VARCHAR(255),
                    cat VARCHAR(255),
                    color VARCHAR(255),
                    size VARCHAR(50),
                    state VARCHAR(50),
                    name VARCHAR(255),
                    status VARCHAR(255),
                    user_id BIGINT UNSIGNED,
                    FOREIGN KEY (user_id) REFERENCES {$wpdb->prefix}users(ID)
                )";
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }
}

// Enregistre un shortcode qui affiche simplement un espace réservé pour notre application React.
add_shortcode( 'example_react_app', 'example_react_app' );

/**
 * Registers a shortcode that simply displays a placeholder for our React App.
 */
function example_react_app( $atts = array(), $content = null , $tag = 'example_react_app' ){
    ob_start();
?>
        <div id="app">App goes heress</div>
        <?php wp_enqueue_script( 'example-app', plugins_url( './build/index.js', __FILE__ ), array( 'wp-element' ), time(), true ); ?>
    <?php return ob_get_clean();
}
add_action( 'wp_ajax_get_user_data', 'example_react_app' );

