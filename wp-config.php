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
define('DB_NAME', 'JystrupDB');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '-Nqc]#L7<rhz+0kBoQ 9^pLCZ9%&pF@JSO$=k~S^=+:9n7N=NV82W-X{3s2d+X(N');
define('SECURE_AUTH_KEY',  'iz8TB|||%1(6.]o2bBM0(*5?`YvfQVn8$BUi%N_z_Z.u;KN9B<~ay~BxHSt@mc2G');
define('LOGGED_IN_KEY',    'Ap_F9^qU8)=tm[3Wf`2mE!xG%HBH&DKM=QZ)x0zy4CM~:y{MRu$n$*tRz~(Uc~|x');
define('NONCE_KEY',        'on}+#xna@LmQ8/#9E7<_XMQ9@G+)YVd53 P%!nX9[<hEi]Mn3^R >{T`^ iYaM)9');
define('AUTH_SALT',        'wC*@KZqjkcdo@B|}/aqn,7GegRc3@9:l}{!4iqI<I0YH}^,lUWQAWYsi)*{N(q|_');
define('SECURE_AUTH_SALT', '>2_Ab:(W&.8&kESz;l5&iO^WIyc@r=MW}_:NgdH|}:+<64|9<fl{;s9H5Z]^k@oF');
define('LOGGED_IN_SALT',   ' />878w*s5/qa!,47iq;yCs4$#GN0DtGLeUG>4-;^RAlr]LE_fQ)X/^=4O=N-=ve');
define('NONCE_SALT',       'l+QS?cp_^ <*AqQPy[P7.q=3c9_qYYcJ$y-(@gTd#nH+Tyb@. 52|}U#z)u]%WYq');

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
