<?php
add_action( 'rest_api_init', 'register_categories_api_routes_by_parent' );

function register_categories_api_routes_by_parent() {
    register_rest_route( 'categories-search-api/v1', '/by-parent/(?P<parent_category_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_categories_by_parent',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_categories_by_parent( $request ) {
    global $wpdb;
    $parent_category_id = intval( $request['parent_category_id'] );
    $table_name = $wpdb->prefix . 'categories';

    $categories = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE parent_category_id = %d", $parent_category_id ), ARRAY_A );

    if ( $categories ) {
        return new WP_REST_Response( $categories, 200 );
    } else {
        return new WP_Error( 'no_categories', 'Aucune catégorie trouvée pour cette catégorie parente', array( 'status' => 404 ) );
    }
}
