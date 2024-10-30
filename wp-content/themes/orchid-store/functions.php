<?php
/**
 * Orchid Store functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Orchid_Store
 */

$current_theme = wp_get_theme( 'orchid-store' );

define( 'ORCHID_STORE_VERSION', $current_theme->get( 'Version' ) );

if ( ! function_exists( 'orchid_store_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function orchid_store_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Orchid Store, use a find and replace
		 * to change 'orchid-store' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'orchid-store', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'orchid-store-thumbnail-extra-large', 800, 600, true );
		add_image_size( 'orchid-store-thumbnail-large', 800, 450, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', 'orchid-store' ),
				'menu-2' => esc_html__( 'Secondary Menu', 'orchid-store' ),
				'menu-3' => esc_html__( 'Top Header Menu', 'orchid-store' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'orchid_store_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 70,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Remove block widget support in WordPress version 5.8 & later.
		 *
		 * @link https://make.wordpress.org/core/2021/06/29/block-based-widgets-editor-in-wordpress-5-8/
		 */
		remove_theme_support( 'widgets-block-editor' );
	}

	add_action( 'after_setup_theme', 'orchid_store_setup' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function orchid_store_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'orchid_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'orchid_store_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function orchid_store_scripts() {

	wp_enqueue_style(
		'orchid-store-style',
		get_stylesheet_uri(),
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-fonts',
		orchid_store_lite_fonts_url(),
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-boxicons',
		get_template_directory_uri() . '/assets/fonts/boxicons/boxicons.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-fontawesome',
		get_template_directory_uri() . '/assets/fonts/fontawesome/fontawesome.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	if ( is_rtl() ) {

		wp_enqueue_style(
			'orchid-store-main-style-rtl',
			get_template_directory_uri() . '/assets/dist/css/main-style-rtl.css',
			array(),
			ORCHID_STORE_VERSION,
			'all'
		);

		wp_add_inline_style(
			'orchid-store-main-style-rtl',
			orchid_store_dynamic_style()
		);
	} else {

		wp_enqueue_style(
			'orchid-store-main-style',
			get_template_directory_uri() . '/assets/dist/css/main-style.css',
			array(),
			ORCHID_STORE_VERSION,
			'all'
		);

		wp_add_inline_style(
			'orchid-store-main-style',
			orchid_store_dynamic_style()
		);
	}

	wp_register_script(
		'orchid-store-bundle',
		get_template_directory_uri() . '/assets/dist/js/bundle.min.js',
		array( 'jquery' ),
		ORCHID_STORE_VERSION,
		true
	);

	$script_obj = array(
		'ajax_url'              => esc_url( admin_url( 'admin-ajax.php' ) ),
		'homeUrl'               => esc_url( home_url() ),
		'isUserLoggedIn'        => is_user_logged_in(),
		'isCartMessagesEnabled' => orchid_store_get_option( 'enable_cart_messages' ),
	);

	$script_obj['scroll_top'] = orchid_store_get_option( 'display_scroll_top_button' );

	if ( class_exists( 'WooCommerce' ) ) {

		if ( get_theme_mod( 'orchid_store_field_product_added_to_cart_message', esc_html__( 'Product successfully added to cart!', 'orchid-store' ) ) ) {

			$script_obj['added_to_cart_message'] = get_theme_mod( 'orchid_store_field_product_added_to_cart_message', esc_html__( 'Product successfully added to cart!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_product_removed_from_cart_message', esc_html__( 'Product has been removed from your cart!', 'orchid-store' ) ) ) {

			$script_obj['removed_from_cart_message'] = get_theme_mod( 'orchid_store_field_product_removed_from_cart_message', esc_html__( 'Product has been removed from your cart!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_cart_update_message', esc_html__( 'Cart items has been updated successfully!', 'orchid-store' ) ) ) {

			$script_obj['cart_updated_message'] = get_theme_mod( 'orchid_store_field_cart_update_message', esc_html__( 'Cart items has been updated successfully!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_product_cols_in_mobile', 1 ) ) {
			$script_obj['product_cols_on_mobile'] = get_theme_mod( 'orchid_store_field_product_cols_in_mobile', 1 );
		}

		if ( get_theme_mod( 'orchid_store_field_display_plus_minus_btns', true ) ) {
			$script_obj['displayPlusMinusBtns'] = get_theme_mod( 'orchid_store_field_display_plus_minus_btns', true );
		}

		if ( get_theme_mod( 'orchid_store_field_cart_display', 'default' ) ) {
			$script_obj['cartDisplay'] = ( class_exists( 'Addonify_Floating_Cart' ) ) ? apply_filters( 'orchid_store_cart_display_filter', get_theme_mod( 'orchid_store_field_cart_display', 'default' ) ) : 'default';
		}

		if ( class_exists( 'Addonify_Wishlist' ) ) {
			$script_obj['addToWishlistText']     = get_option( 'addonify_wishlist_btn_label', 'Add to wishlist' );
			$script_obj['addedToWishlistText']   = get_option( 'addonify_wishlist_btn_label_when_added_to_wishlist', 'Added to wishlist' );
			$script_obj['alreadyInWishlistText'] = get_option( 'addonify_wishlist_btn_label_if_added_to_wishlist', 'Already in wishlist' );
		}
	}

	wp_localize_script( 'orchid-store-bundle', 'orchid_store_obj', $script_obj );

	wp_enqueue_script( 'orchid-store-bundle' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'orchid_store_scripts' );


/**
 * Enqueue scripts and styles for admin.
 */
function orchid_store_admin_enqueue() {

	wp_enqueue_script( 'media-upload' );

	wp_enqueue_media();

	wp_enqueue_style(
		'orchid-store-admin-style',
		get_template_directory_uri() . '/admin/css/admin-style.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_script(
		'orchid-store-admin-script',
		get_template_directory_uri() . '/admin/js/admin-script.js',
		array( 'jquery' ),
		ORCHID_STORE_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'orchid_store_admin_enqueue' );
add_action( 'wp_ajax_wp_ajax_install_plugin', 'wp_ajax_install_plugin' );





/**
 * Activates AFC plugin.
 *
 * @since 1.0.0
 */
function orchid_store_activate_plugin() {

	$return_data = array(
		'success' => false,
		'message' => '',
	);

	if ( ! current_user_can( 'manage_options' ) ) {
		$return_data['message'] = esc_html__( 'User can not activate plugins.', 'orchid-store' );
		wp_send_json( $return_data );
	}

	if ( isset( $_POST['_ajax_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_ajax_nonce'] ) ), 'updates' ) ) {
		$return_data['message'] = esc_html__( 'Invalid security token.', 'orchid-store' );
		wp_send_json( $return_data );
	}

	$activation = activate_plugin( WP_PLUGIN_DIR . '/addonify-floating-cart/addonify-floating-cart.php' );

	if ( ! is_wp_error( $activation ) ) {

		$return_data['success'] = true;
		$return_data['message'] = esc_html__( 'The plugin is activated successfully.', 'orchid-store' );
	} else {

		$return_data['message'] = $activation->get_error_message();
	}

	wp_send_json( $return_data );
}
add_action( 'wp_ajax_orchid_store_activate_plugin', 'orchid_store_activate_plugin' );


if ( defined( 'ELEMENTOR_VERSION' ) ) {

	add_action( 'elementor/editor/before_enqueue_scripts', 'orchid_store_admin_enqueue' );
}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/customizer/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {

	require get_template_directory() . '/inc/woocommerce.php';

	require get_template_directory() . '/inc/woocommerce-hooks.php';
}

/**
 * Load breadcrumb trails.
 */
require get_template_directory() . '/third-party/class-orchid-store-breadcrumb-trail.php';

/**
 * Load TGM plugin activation.
 */
require get_template_directory() . '/third-party/class-tgm-plugin-activation.php';

/**
 * Load plugin recommendations.
 */
require get_template_directory() . '/inc/plugin-recommendation.php';

/**
 * Load custom hooks necessary for theme.
 */
require get_template_directory() . '/inc/custom-hooks.php';

/**
 * Load custom hooks necessary for theme.
 */
require get_template_directory() . '/inc/udp/init.php';


/**
 * Load function that enhance theme functionality.
 */
require get_template_directory() . '/inc/theme-functions.php';


/**
 * Load option choices.
 */
require get_template_directory() . '/inc/option-choices.php';


/**
 * Load widgets and widget areas.
 */
require get_template_directory() . '/widget/widgets-init.php';


/**
 * Load custom fields.
 */
require get_template_directory() . '/inc/class-orchid-store-custom-fields.php';

/**
 * Load theme dependecies
 */
require get_template_directory() . '/vendor/autoload.php';

// Replace "Add to Cart" button with WhatsApp button on shop page and product page
// add_filter('woocommerce_loop_add_to_cart_link', 'replace_add_to_cart_with_whatsapp', 10, 2);
// add_filter('woocommerce_product_single_add_to_cart_text', 'replace_single_add_to_cart_with_whatsapp'); // For single product page

// function replace_add_to_cart_with_whatsapp($link, $product) {
//     // Get product details
//     $product_name = $product->get_name();
//     $product_price = $product->get_price();
//     $product_url = get_permalink($product->get_id());
//     $product_image = wp_get_attachment_url($product->get_image_id());

//     // WhatsApp message text
//     $whatsapp_message = urlencode("Hello! I'm interested in the following product:\n\nProduct Name: $product_name\nPrice: $product_price\nURL: $product_url\nImage: $product_image");

//     // WhatsApp button HTML
//     $whatsapp_link = "https://api.whatsapp.com/send?text=$whatsapp_message";

//     return '<a href="' . esc_url($whatsapp_link) . '" class="button alt" style="background-color: #25D366; color: white; padding: 10px 20px; border-radius: 5px;" target="_blank">Send on WhatsApp</a>';
// }

// function replace_single_add_to_cart_with_whatsapp() {
//     return 'Send on WhatsApp'; // Change button text on single product page
// }
// Replace "Add to Cart" button with WhatsApp and Quick View buttons
add_filter('woocommerce_loop_add_to_cart_link', 'replace_add_to_cart_with_whatsapp_and_quick_view', 10, 2);
add_filter('woocommerce_product_single_add_to_cart_text', 'replace_single_add_to_cart_with_whatsapp_and_quick_view'); // For single product page

function replace_add_to_cart_with_whatsapp_and_quick_view($link, $product) {
    // Get product details
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $product_url = get_permalink($product->get_id());
    $product_image = wp_get_attachment_url($product->get_image_id());

    // WhatsApp message text
    $whatsapp_message = urlencode("Hello! I'm interested in the following product:\n\nProduct Name: $product_name\nPrice: $product_price\nURL: $product_url\nImage: $product_image");

    // WhatsApp button HTML
    $whatsapp_link = "https://api.whatsapp.com/send?text=$whatsapp_message";
    
    // Quick View button HTML
  //  $quick_view_button = '<button class="open-popup" data-product-id="' . $product->get_id() . '" style="color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; text-transform: uppercase; border:1px solid;">Quick View</button>';
	
	$quick_view_button = '<a class="whatsapp-button button alt" href="tel:949463859866" style="background-color: #0286e7;  color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; text-transform: uppercase; border:1px solid;">Call Now</a>';

    return '<a href="' . esc_url($whatsapp_link) . '" class="whatsapp-button button alt " style="background-color: #0286e7; color: white; padding: 10px 20px; border-radius: 5px;" target="_blank"> <i class="whatsapp fab fa-whatsapp"></i> Chat Now</a>' . $quick_view_button;
}

function replace_single_add_to_cart_with_whatsapp_and_quick_view() {
    return 'Send on WhatsApp'; // Change button text on single product page
}

// AJAX handler to fetch product details
add_action('wp_ajax_get_product_details', 'get_product_details');
add_action('wp_ajax_nopriv_get_product_details', 'get_product_details');

function get_product_details() {
    $product_id = intval($_GET['product_id']);
    $product = wc_get_product($product_id);

    if ($product) {
        $response = [
            'name'        => $product->get_name(),
            'price'       => $product->get_price(),
            'image'       => wp_get_attachment_url($product->get_image_id()),
            'description' => $product->get_description(),
            'url'         => get_permalink($product->get_id()),
        ];

        wp_send_json($response);
    }

    wp_die(); // Important to end the AJAX request properly
}

// add_action( 'woocommerce_after_add_to_cart_button', 'add_custom_button' );

// function add_custom_button() {
//    $quick_view_button = '<a class="whatsapp-button button alt" href="tel:949463859866" style="background-color: #0286e7;  color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; text-transform: uppercase; border:1px solid;">Call Now</a>';

//      echo '<a href="#" class="whatsapp-button button alt " style="background-color: #0286e7; color: white; padding: 8px 20px; border-radius: 5px;" target="_blank"> <i class="whatsapp fab fa-whatsapp"></i> Chat Now</a>' . $quick_view_button;
// }

// Add WhatsApp button after "Add to Cart" button
add_action( 'woocommerce_after_add_to_cart_button', 'add_whatsapp_button' );

function add_whatsapp_button() {
    global $product;
    
    // Get the product details
    $product_name  = $product->get_name();  // Get product name
    $product_price = $product->get_price(); // Get product price
    $product_image = wp_get_attachment_url( $product->get_image_id() ); // Get product image URL

    // Create the WhatsApp message
    $whatsapp_message = "Hello, I'm interested in this product:\n\n";
    $whatsapp_message .= "Product: *" . $product_name . "*\n";
    $whatsapp_message .= "Price: " . wc_price( $product_price ) . "\n";
    $whatsapp_message .= "Image: " . $product_image . "\n\n";
    $whatsapp_message .= "Please let me know more details.";

    // WhatsApp URL (Replace "whatsapp_number" with your actual number or leave it blank)
    $whatsapp_url = "https://wa.me/?text=" . urlencode( $whatsapp_message );

	$quick_view_button = '<a class="whatsapp-button button alt" href="tel:949463859866" style="background-color: #0286e7;  color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; text-transform: uppercase; border:1px solid;">Call Now</a>';
	
    // Output the WhatsApp button
    echo '<a href="' . esc_url($whatsapp_url) . '" class="whatsapp-button button alt " style="background-color: #0286e7; color: white; padding: 10px 20px; border-radius: 5px;" target="_blank"> <i class="whatsapp fab fa-whatsapp"></i> Chat Now</a>' . $quick_view_button;
}
