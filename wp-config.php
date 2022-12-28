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
define( 'DB_NAME', 'demosite' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         ';U~!0PAf>o^7%[N>9V,ldkd:s?TH+.A}*E}okmZ*Nvj?~AmJMARP@?]eDb@Ma[hm' );
define( 'SECURE_AUTH_KEY',  'Fs98B!5SrF`WF|(dZk}Rxd*V@T8ozmci:zK4f0l@,w -1OISviicP(FNU4c>n~::' );
define( 'LOGGED_IN_KEY',    't(M^L,wY)y[;2n|P6>>4O:TV9(?w3]]AkKH,*f;k8i9|L>c(q;5YE{4SmMYw))PT' );
define( 'NONCE_KEY',        '^U>HK6];(udZ@`9b/zOCp_nhf Ej??Ik5V]xFVUb!jm}:W~Mx#-7;CNATTeV`3o:' );
define( 'AUTH_SALT',        'YZPd@cX9op5n<xyHMPu6SV4 /=4+uUv3B}>AH5B8`O.7z)#gjM{M1Zej[ &`d|Aw' );
define( 'SECURE_AUTH_SALT', '!gml8iMf_>kA/,vXk)w.DkPH}H8RFr_vdhSNF^[d,krSRuz- a#gJWK~2q2)b2mK' );
define( 'LOGGED_IN_SALT',   '5C:O.&DS.jUK^+DwTb!G~otT/SbTxyCiDhozJO>E%2Eh+(6x2&F;%S#mu_Oo3po=' );
define( 'NONCE_SALT',       'k_mN5<.-OmChp<i1*t?5! ?1lFYPpqDy8<`*0~{pBdN> iEo>/*L7qV^:SKdp7rV' );

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
