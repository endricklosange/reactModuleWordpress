<?php

/**
 * Plugin Name: React Example
 */
defined('ABSPATH') || die();

// In main plugin file
register_activation_hook(__FILE__, 'example_react_activation');
require_once("api/createProduitsSearch.php");
require_once("api/getAllProduitsSearch.php");
require_once("api/getProduitsSearch.php");
require_once("api/getAllGenre.php");
require_once("api/getParentCategories.php");
require_once("api/getCategories.php");
require_once("api/getSizes.php");
require_once("api/getColors.php");

/**
 * Function to create necessary database tables upon plugin activation.
 */
function enqueue_custom_script()
{
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
function example_react_activation()
{
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $tables = [];

    // Table definitions
    $tables['produit_search'] = "
        CREATE TABLE {$wpdb->prefix}produit_search (
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
        ) $charset_collate;
    ";

    $tables['genres'] = "
        CREATE TABLE {$wpdb->prefix}genres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        ) $charset_collate;
    ";

    $tables['parentcategories'] = "
        CREATE TABLE {$wpdb->prefix}parentcategories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            genre_id INT,
            name VARCHAR(255) NOT NULL,
            FOREIGN KEY (genre_id) REFERENCES {$wpdb->prefix}genres(id)
        ) $charset_collate;
    ";

    $tables['categories'] = "
        CREATE TABLE {$wpdb->prefix}categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            parent_category_id INT,
            name VARCHAR(255) NOT NULL,
            FOREIGN KEY (parent_category_id) REFERENCES {$wpdb->prefix}parentcategories(id)
        ) $charset_collate;
    ";

    $tables['colors'] = "
        CREATE TABLE {$wpdb->prefix}colors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        ) $charset_collate;
    ";

    $tables['sizes'] = "
        CREATE TABLE {$wpdb->prefix}sizes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        ) $charset_collate;
    ";

    $tables['sizetypes'] = "
        CREATE TABLE {$wpdb->prefix}sizetypes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        ) $charset_collate;
    ";

    $tables['categorysizes'] = "
        CREATE TABLE {$wpdb->prefix}categorysizes (
            category_id INT,
            size_id INT,
            size_type_id INT,
            FOREIGN KEY (category_id) REFERENCES {$wpdb->prefix}categories(id),
            FOREIGN KEY (size_id) REFERENCES {$wpdb->prefix}sizes(id),
            FOREIGN KEY (size_type_id) REFERENCES {$wpdb->prefix}sizetypes(id)
        ) $charset_collate;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Create tables if not exist
    foreach ($tables as $table_name => $create_table_sql) {
        if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}{$table_name}'") != "{$wpdb->prefix}{$table_name}") {
            dbDelta($create_table_sql);
        }
    }

    // Data to insert
    $genres_data = ['Homme', 'Femme', 'Enfant'];
    $parent_categories_data = [
        'Homme' => ['Haut', 'Bas', 'Accessoires', 'Chaussures'],
        'Femme' => ['Haut', 'Bas', 'Accessoires', 'Chaussures', 'Robe'],
        'Enfant' => ['Haut', 'Bas', 'Accessoires', 'Chaussures']
    ];
    $categories_data = [
        'Haut Homme' => ['Veste', 'T-shirt', 'Pull', 'Manteau', 'Débardeur'],
        'Bas Homme' => ['Pantalon', 'Short', 'Jean', 'Short de bain', 'Pantalon de survêtement'],
        'Bas Femme' => ['Jupe', 'Pantalon', 'Short', 'Jean', 'Legging'],
        'Bas Enfant' => ['Pantalon', 'Short', 'Jupe', 'Jean', 'Legging'],
        'Accessoires Homme' => ['Casquette', 'Ceinture', 'Montre', 'Sac à dos', 'Lunettes de soleil', 'Cravate', 'Écharpe'],
        'Accessoires Femme' => ['Sac à main', 'Écharpe', 'Collier', 'Bracelet', 'Chapeau', 'Boucles d’oreilles', 'Ceinture'],
        'Accessoires Enfant' => ['Casquette', 'Sac à dos', 'Lunettes de soleil', 'Bonnet', 'Gants'],
        'Chaussures Homme' => ['Chaussures habillées', 'Bottes', 'Sandales', 'Sneackers', 'Chaussures de sport'],
        'Chaussures Femme' => ['Talons', 'Bottes', 'Sandales', 'Chaussures plates', 'Sneackers'],
        'Chaussures Enfant' => ['Chaussures de sport', 'Bottes', 'Sandales', 'Chaussures habillées', 'Sneackers'],
        'Haut Femme' => ['Blouse', 'T-shirt', 'Pull', 'Manteau', 'Débardeur'],
        'Haut Enfant' => ['T-shirt', 'Sweatshirt', 'Pull', 'Veste', 'Débardeur'],
    ];
    $colors_data = ['Rouge', 'Noir', 'Bleu', 'Jaune', 'Marron', 'Vert', 'Orange', 'Rose', 'Violet', 'Blanc', 'Gris', 'Beige', 'Bordeaux', 'Turquoise'];
    $sizes_accessories = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
    $shoes_sizes_data = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'];
    $sizes_clothes = ['XXS','XS', 'S', 'M', 'L', 'XL', 'XXL','32','34','36','38','40','42','44','46','48','50','52','54'];

    // Insert genres
    $genres = [];
    foreach ($genres_data as $genre) {
        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}genres WHERE name = %s", $genre));
        if (!$exists) {
            $wpdb->insert("{$wpdb->prefix}genres", ['name' => $genre]);
            $genres[$genre] = $wpdb->insert_id;
        } else {
            $genres[$genre] = $exists;
        }
    }

    // Insert parent categories
    $parent_categories = [];
    foreach ($parent_categories_data as $genre_name => $parent_cats) {
        foreach ($parent_cats as $parent_cat) {
            $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}parentcategories WHERE name = %s AND genre_id = %d", $parent_cat, $genres[$genre_name]));
            if (!$exists) {
                $wpdb->insert("{$wpdb->prefix}parentcategories", [
                    'genre_id' => $genres[$genre_name],
                    'name' => $parent_cat
                ]);
                $parent_categories[$genre_name][$parent_cat] = $wpdb->insert_id;
            } else {
                $parent_categories[$genre_name][$parent_cat] = $exists;
            }
        }
    }

    // Insert categories
    foreach ($categories_data as $parent_cat_name => $cats) {
        list($parent_cat_base, $genre_name) = explode(' ', $parent_cat_name, 2);
        foreach ($cats as $cat) {
            $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}categories WHERE name = %s AND parent_category_id = %d", $cat, $parent_categories[$genre_name][$parent_cat_base]));
            if (!$exists) {
                $wpdb->insert("{$wpdb->prefix}categories", [
                    'parent_category_id' => $parent_categories[$genre_name][$parent_cat_base],
                    'name' => $cat
                ]);
            }
        }
    }

    // Insert colors
    foreach ($colors_data as $color) {
        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}colors WHERE name = %s", $color));
        if (!$exists) {
            $wpdb->insert("{$wpdb->prefix}colors", ['name' => $color]);
        }
    }

    // Insert sizes accessories
    foreach ($sizes_accessories as $size) {
        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
        if (!$exists) {
            $wpdb->insert("{$wpdb->prefix}sizes", ['name' => $size]);
        }
    }
    // Insert sizes clothes
    foreach ($sizes_clothes as $size) {
        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
        if (!$exists) {
            $wpdb->insert("{$wpdb->prefix}sizes", ['name' => $size]);
        }
    }
    // Insert shoe sizes
    foreach ($shoes_sizes_data as $size) {
        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
        if (!$exists) {
            $wpdb->insert("{$wpdb->prefix}sizes", ['name' => $size]);
        }
    }
      // Insert shoe sizes type
      $sizetypes_data = ['shoes', 'clothes','accessories'];
      foreach ($sizetypes_data as $sizetype) {
          $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizetypes WHERE name = %s", $sizetype));
          if (!$exists) {
              $wpdb->insert("{$wpdb->prefix}sizetypes", ['name' => $sizetype]);
          }
      }
    // Insert category sizes for each category
    foreach ($categories_data as $parent_cat_name => $cats) {
        $parent_cat_base = explode(' ', $parent_cat_name)[0];

        if ($parent_cat_base === 'Chaussures') {
            $sizetype = 'shoes';
        } elseif ($parent_cat_base === 'Accessoires') {
            $sizetype = 'accessories';    
        } else {
            $sizetype = 'clothes';
        }
        foreach ($cats as $cat) {
            error_log("cat: $cat");

            $category_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}categories WHERE name = %s", $cat));
            $sizetype_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizetypes WHERE name = %s", $sizetype));

            // Vérify if data already exists
            $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}categorysizes WHERE category_id = %d AND size_type_id = %d", $category_id, $sizetype_id));
            // if not insert the data
            if (!$exists) {
                // Insert the sizes corresponding to the size type
                if ($sizetype === 'shoes') {
                    foreach ($shoes_sizes_data as $size) {
                        $size_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
                        $wpdb->insert("{$wpdb->prefix}categorysizes", [
                            'category_id' => $category_id,
                            'size_id' => $size_id,
                            'size_type_id' => $sizetype_id
                        ]);
                    }
                } elseif ($sizetype === 'accessories') {
                    foreach ($sizes_accessories as $size) {
                        $size_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
                        $wpdb->insert("{$wpdb->prefix}categorysizes", [
                            'category_id' => $category_id,
                            'size_id' => $size_id,
                            'size_type_id' => $sizetype_id
                        ]);
                    }
                } else {
                    foreach ($sizes_clothes as $size) {
                        $size_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}sizes WHERE name = %s", $size));
                        $wpdb->insert("{$wpdb->prefix}categorysizes", [
                            'category_id' => $category_id,
                            'size_id' => $size_id,
                            'size_type_id' => $sizetype_id
                        ]);
                    }
                }
            }
        }
    }
}



// Enregistre un shortcode qui affiche simplement un espace réservé pour notre application React.
add_shortcode('example_react_app', 'example_react_app');

/**
 * Registers a shortcode that simply displays a placeholder for our React App.
 */
function example_react_app($atts = array(), $content = null, $tag = 'example_react_app')
{
    ob_start();
?>
    <div id="app">App goes heress</div>
    <?php wp_enqueue_script('example-app', plugins_url('./build/index.js', __FILE__), array('wp-element'), time(), true); ?>
<?php return ob_get_clean();
}
add_action('wp_ajax_get_user_data', 'example_react_app');
