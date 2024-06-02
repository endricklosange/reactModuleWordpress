<?php
add_action( 'rest_api_init', 'register_parentcategories_api_routes_by_genre' );

function register_parentcategories_api_routes_by_genre() {
    register_rest_route( 'parentcategories-search-api/v1', '/by-genre/(?P<genre_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_parentcategories_by_genre',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_parentcategories_by_genre( $request ) {
    global $wpdb;
    $genre_id = intval( $request['genre_id'] );
    $table_name = $wpdb->prefix . 'parentcategories';

    $parentcategories = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE genre_id = %d", $genre_id ), ARRAY_A );

    if ( $parentcategories ) {
        return new WP_REST_Response( $parentcategories, 200 );
    } else {
        return new WP_Error( 'no_parentcategories', 'Aucune catégorie parent trouvée pour ce genre', array( 'status' => 404 ) );
    }
}
