<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'freedb__travel' );

/** Database username */
define( 'DB_USER', 'freedb__travel' );

/** Database password */
define( 'DB_PASSWORD', 'GSz6KKJUsmv6uG!' );

/** Database hostname */
define( 'DB_HOST', 'sql.freedb.tech' );

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
define( 'AUTH_KEY',         'B`69;|O[m1l%(+I4ynkR>&+VxZ^CP_k<U<vMuXX(!SdOVN_ynqIc0GwUt]eFHx{}' );
define( 'SECURE_AUTH_KEY',  'C UiJM%f58_FB-Y)`f/&[`Y}[c~SuiNfHxlNfkHldP|3q3mVG(nUKtu,v5V]A?Q`' );
define( 'LOGGED_IN_KEY',    '_)b{pH8dl3&%Ii9$[NczRRMxO`foL}oNg_4!OV[w9luFpd@2[Urg*M,4=V56b9bD' );
define( 'NONCE_KEY',        '[M,1R`nhiv?95Ndq#Wd4|J?,%M5y4c08LwVa/WPpw6Jk/-)O(Q[iNi>1=htFA)QK' );
define( 'AUTH_SALT',        'ZA6Wa`|9nkXA^jDI5VvtrCB}_yWaUapSx#@g11}`H_N4@[)dLA@j}s_vu#/E`qYP' );
define( 'SECURE_AUTH_SALT', 'Cz`uM/+!O].I>GVSywd DgRjwLsLtGZFO1%!-iS}5k>:Wp<f4.s+?~,sqrT-^OwY' );
define( 'LOGGED_IN_SALT',   'NohO=wR,6zR*1ZQ_bqw  2CW7D:d{6EG2y`@Q=%d3f6V[ys8;0d|>o3B8N$9U8SU' );
define( 'NONCE_SALT',       'n&oHue-r7nV{#lX{%k91ndYL~GG;1TiwH*Y%Z~]!57a(i<Lv+EjjCau)Af!{0fWJ' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
