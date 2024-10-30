<?php
define( 'WP_CACHE', true );


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hamddngt_modernsales_db' );

/** Database username */
define( 'DB_USER', 'hamddngt_modern_sales' );

/** Database password */
define( 'DB_PASSWORD', 'bDKI&VE!9F%1' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e:tu0xii,}3$30?jo<tI5GCS~z<F1Y1W+(_xzp$MdJf][g;j~j_U,Wh?Sa&nhE64' );
define( 'SECURE_AUTH_KEY',  '.Y7I@(2T!gd}pxfoM-[7<f7/-Wv<584P3=)umI^+erbbd`Z^r-iWi$1=9kVKNs{F' );
define( 'LOGGED_IN_KEY',    ';roUg4[LS;tTH,-O-F1{6j1L+]r5=H#E)n.-([TL2!3(._-0t:OB4&/haLu5e4iZ' );
define( 'NONCE_KEY',        'B0*!;D_6aU@xce?6iR]CA>{,56VUn3c(B+uy[=uMD;Vh8(kN&.qam*gg7ruZOKPx' );
define( 'AUTH_SALT',        'V1}6+)pV1jI?f(mh{BARg}q}S}.Apw>4&`*[<lB)48z@kQWPZ?8o+7r%:7FA/5A&' );
define( 'SECURE_AUTH_SALT', 'sV[;BfxZ3;In)4U6+ER2m]XbE{amQe>*-:Q~1^`26%2_{W7>=8U(h`~]zJ jr<h4' );
define( 'LOGGED_IN_SALT',   'R_~^+c%<MW7~QWOya-eoS~K;nKne/zTgQ.Hak9{bA|b0|p1c+s-{~?Ww2>_Cm>2w' );
define( 'NONCE_SALT',       'ktw7Rv1w06X 68-@?=VAG(kd<@)4H&j]~||Sm[hjP:SN*84L3INoE8:<:ECxVXcx' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */


define('DISALLOW_FILE_EDIT', true);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
