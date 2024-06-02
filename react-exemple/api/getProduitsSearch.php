<?php

add_action('rest_api_init', 'register_produits_api_routes_get');

function register_produits_api_routes_get()
{
    register_rest_route('produits-search-api/v1', '/user/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_user_by_id',
    ));
}

function get_user_by_id($data)
{

    // Vérifier si l'utilisateur connecté correspond à l'utilisateur demandé
    $table_name = $wpdb->prefix . 'produit_search';
    $user_id = $data['id'];
    // Récupérer tous les produits de la table pour l'utilisateur spécifié
    $produits = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $user_id", ARRAY_A);

    // Vérifier si des produits ont été trouvés
    if ($produits) {
        var_dump($_SESSION['testing']);
        // Si oui, retourner les produits sous forme de réponse JSON
        return new WP_REST_Response($produits, 200);
    } else {
        // Si aucun produit n'a été trouvé, retourner une erreur
        return new WP_Error('no_produits', 'Aucun produit trouvé', array('status' => 404));
    }
}

