<?php
add_action( 'rest_api_init', 'register_genres_api_routes_get_all' );

function register_genres_api_routes_get_all() {
    register_rest_route( 'genres-search-api/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_genres',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_all_genres() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'genres';

    $genres = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

    if ( $genres ) {
        return new WP_REST_Response( $genres, 200 );
    } else {
        return new WP_Error( 'no_genres', 'Aucun genre trouvé', array( 'status' => 404 ) );
    }
}
