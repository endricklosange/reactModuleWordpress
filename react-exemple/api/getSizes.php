<?php
add_action( 'rest_api_init', 'register_sizes_api_routes_by_category' );

function register_sizes_api_routes_by_category() {
    register_rest_route( 'sizes-search-api/v1', '/by-category/(?P<category_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_sizes_by_category',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_sizes_by_category( $request ) {
    global $wpdb;
    $category_id = intval( $request['category_id'] );

    $sizes = $wpdb->get_results( $wpdb->prepare( 
        "SELECT wp_sizes.* FROM {$wpdb->prefix}sizes 
        JOIN {$wpdb->prefix}categorysizes ON {$wpdb->prefix}sizes.id = {$wpdb->prefix}categorysizes.size_id 
        WHERE {$wpdb->prefix}categorysizes.category_id = %d", $category_id ), ARRAY_A );

    if ( $sizes ) {
        return new WP_REST_Response( $sizes, 200 );
    } else {
        return new WP_Error( 'no_sizes', 'Aucune taille trouvée pour cette catégorie', array( 'status' => 404 ) );
    }
}
