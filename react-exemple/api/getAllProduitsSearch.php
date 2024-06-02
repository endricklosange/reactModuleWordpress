<?php

add_action( 'rest_api_init', 'register_produits_api_routes_get_all' );

function register_produits_api_routes_get_all() {
    register_rest_route( 'produits-search-api/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_produits_and_user',
        /*'permission_callback' => function () {
            return current_user_can( 'edit_posts' );
        }*/
    ) );
}

function get_all_produits_and_user() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'produit_search';

    // Récupérer tous les produits de la table
    $produits = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

    // Vérifier si des produits ont été trouvés
    if ( $produits ) {
        // Si oui, retourner les produits sous forme de réponse JSON
        return new WP_REST_Response( $produits, 200 );
    } else {
        // Si aucun produit n'a été trouvé, retourner une erreur
        return new WP_Error( 'no_produits', 'Aucun produit trouvé', array( 'status' => 404 ) );
    }
}