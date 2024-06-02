<?php
add_action( 'rest_api_init', 'register_colors_api_routes_get_all' );

function register_colors_api_routes_get_all() {
    register_rest_route( 'colors-search-api/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_colors',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_all_colors() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'colors';

    $colors = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

    if ( $colors ) {
        return new WP_REST_Response( $colors, 200 );
    } else {
        return new WP_Error( 'no_colors', 'Aucune couleur trouvée', array( 'status' => 404 ) );
    }
}
