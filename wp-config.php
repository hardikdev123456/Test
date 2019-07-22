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
define( 'DB_NAME', 'wordpressnew' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ':4#o=x?h`+Fq)}2i/Br/YQhf=oaE@2m:@o{)IM6JW%z}lBA3}{w})QpJuT-2YCGz' );
define( 'SECURE_AUTH_KEY',  'Q|@~ynsyH3FcZ*Yd~?_]UY]l+<]b%pjqjRgtk9h@y3jNQx&7Q KD:N2w1V<n$:Mw' );
define( 'LOGGED_IN_KEY',    '<Q=rB3|Y`?xZh;/C[zK?Xvj.x7O>Nn6)}*76DpZp=!oG{k;3eUrm5(yCYo{!+R}#' );
define( 'NONCE_KEY',        'pi0(?W>knI+0Q(j~fu>;FY$y`/(6<douMSTEf7wCNQ oH|q>RxAG`b[NUIpV:LOG' );
define( 'AUTH_SALT',        'Ujj?2Ye?Q_]qp7G(hyI&XP3W>GnH7<=RE^g;A</B5TUb&Zld@W4[d4`6B~+/N EF' );
define( 'SECURE_AUTH_SALT', '|dO<Lyz7fJg+ l.s}MNRP>O,PQ>mWPHiRGwIpk4lCEnl{G o4nO0Zxlp[n0J8QBO' );
define( 'LOGGED_IN_SALT',   '^QpX/<:W)JiG7c{eviiS*Z UF*wb5kDkOs8K:q;[N;2;`B:GiBpouR2;8+RvsYss' );
define( 'NONCE_SALT',       't:._TdHjZkCC!{tUn-@RUWMjI6Wx,5Zl:WjLo[>mmw-|EC#KVwXa$U)0yAqV9#iK' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
