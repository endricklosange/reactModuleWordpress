<?php

add_action( 'rest_api_init', 'register_produits_api_routes_get' );

function register_produits_api_routes_get() {
    register_rest_route( 'produits-search-api/v1', '/user/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_user_by_id',
    ) );
}

function get_user_by_id($data) {
    global $wpdb;
    ob_start();

    $nonce = wp_create_nonce( 'wp_rest' );
// URL de l'API à appeler


// Fermeture de la session curl
$request = new WP_REST_Request( 'GET', '/wp/v2/users/me' );
$request->set_query_params( array( '_wpnonce' => $nonce ) );
$response = rest_do_request( $request );

// Récupérer l'ID de l'utilisateur connecté
$current_user_id = $response->get_data()['id'];
    

    // Récupérer l'ID fourni dans la route
    $requested_user_id = $data['id'];

    // Vérifier si l'utilisateur connecté correspond à l'utilisateur demandé
    if ($current_user_id == $requested_user_id) {
        $table_name = $wpdb->prefix . 'produit_search';
        $user_id = $data['id'];
        
        // Récupérer tous les produits de la table pour l'utilisateur spécifié
        $produits = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id = $user_id", ARRAY_A );

        // Vérifier si des produits ont été trouvés
        if ( $produits ) {
            // Si oui, retourner les produits sous forme de réponse JSON
            return new WP_REST_Response( $produits, 200 );
        } else {
            // Si aucun produit n'a été trouvé, retourner une erreur
            return new WP_Error( 'no_produits', 'Aucun produit trouvé', array( 'status' => 404 ) );
        }
    } else {
        var_dump($response->get_data());
        // Si l'utilisateur connecté n'est pas autorisé, renvoyer une erreur d'autorisation
        return new WP_Error( 'unauthorized', 'Vous n\'êtes pas autorisé à accéder à ces données', array( 'status' => 403 ) );
    }
}
