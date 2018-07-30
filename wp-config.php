<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'smartkeeper');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', '123EWQasd');

/** MySQL hostname */
define('DB_HOST', '140.125.33.31');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZzO23p``KJ]p5h8&~9iL,7WnT_,;~i!_2}x27x/3<!JLpbb4gu+SC.,68(,v)tAa');
define('SECURE_AUTH_KEY',  '3oc8,eRHT<rGQ#I;v{)(;{*FcC#PK<CJA{PZw^uUAat uv^ew8xCo/LD?5d-tZRl');
define('LOGGED_IN_KEY',    '^hsW3H<Rzo/j?H`B99alJuOkv+s.fCL6TWoD2W.Mytyyk@Pbv%pY45k,%Z(`/=|{');
define('NONCE_KEY',        '~UQ)@p7Y Zj9~srIFHH=ah:2@F{%VFv7FK}4gq+xs/O02;7Rgs$N>H@<6~*5Fg8L');
define('AUTH_SALT',        '16TunM$7(qaie&*tuYlZcLD~aWqiCI)rkFtT}jq/5A!<5l@l3T`{qydhs mu@iq,');
define('SECURE_AUTH_SALT', '?2>_0Vi+CM5<1pdFh#-drk2ROJfJ7MVojJky=n(pQm+*j?DEzga2( a4H*[PDeKx');
define('LOGGED_IN_SALT',   'QibsX#Nd*pZ^{V{ZajL3G?=@oQ415i)DZ,6a<4%ijXYx.32)<&+AI%Eva@w`g=M<');
define('NONCE_SALT',       'g;`_Jh>$vACaJcGw56;0h}I!7b,o#hA(u4+bdA5QG*{xW~! pca}o]i)W%&@dZp@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
