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
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'smartkeeper');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '&D%!3%WD(#aR_Ji5xZwi!7Y{Jlae]k/UKl,RKmDcEI4^Vy{*Ch85<Mw)FIv{ A0U');
define('SECURE_AUTH_KEY',  '!YYL%*M8e5CWh:m=%3Xhcx=)aok.q54ycpW_X+(`B$*./*2M}]m7V3PHgR$kIm>y');
define('LOGGED_IN_KEY',    'A,XpFQIdM);r-RK$n]_#1`}g+rc.i@nI-:i,:u({KTLG IDd~AhD[*^N;|1v;c,~');
define('NONCE_KEY',        '*n{J`J:w=u.:gcp$51C3j[v?~55>4V#m=TUcLb%Urh!@qmn:Qq<$Z4GHJol,!G,$');
define('AUTH_SALT',        'qEKy&g10>P~e?bqrr~LBU^(,RRe$q8fn1Gb|h))e0-Fee)3f9I( n]}aq~NrE2xE');
define('SECURE_AUTH_SALT', 'cmWradYDa{>~l`fDz{9_1$+~fq]76I_/RK~!Ba^Q ),Zv%Yao2?=`CZRQ+^JL.E^');
define('LOGGED_IN_SALT',   '-%jMD(?r[@Zt&OjWfxC4vkhf]I+PlHc3{Bk,vvU[#pf(n%jt|Vc;,)- v{~luxZz');
define('NONCE_SALT',       'zJC_NbMnQumuaDu&je]H{5HNd+[cJs2*q-VR&~)DA7=HI+;-ato K!Q(nKh4 T6?');

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
