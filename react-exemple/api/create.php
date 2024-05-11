<?php

add_action( 'rest_api_init', 'register_produits_api_routes_create' );

function register_produits_api_routes_create() {
    register_rest_route( 'produits-search-api/v1', '/insert', array(
        'methods' => 'POST',
        'callback' => 'insert_produit_data',
    ) );
    
}

function insert_produit_data( $request ) {
    $parameters = $request->get_params();

    // Récupération de l'ID de l'utilisateur actuellement connecté
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Récupération des autres données du produit depuis la requête
    $genre = $parameters['genre'];
    $parentcategorie = $parameters['parentcategorie'];
    $cat = $parameters['cat'];
    $color = $parameters['color'];
    $size = $parameters['size'];
    $state = $parameters['state'];
    $name = $parameters['name'];

    // Insérer les données dans la table 'produits'
    global $wpdb;
    $table_name = $wpdb->prefix . 'produit_search';

    $wpdb->insert( 
        $table_name, 
        array( 
            'genre' => $genre,
            'parentcategorie' => $parentcategorie,
            'cat' => $cat,
            'color' => $color,
            'size' => $size,
            'state' => $state,
            'name' => $name,
            'user_id' => $user_id,
        ) 
    );

    // Vérifier si l'insertion a réussi
    if ( $wpdb->insert_id ) {
        return new WP_REST_Response( 'Produit inséré avec succès', 200 );
    } else {
        var_dump($current_user);
        return new WP_Error( 'insert_error', 'Erreur lors de l\'insertion du produit', array( 'status' => 500 ) );
    }
}

