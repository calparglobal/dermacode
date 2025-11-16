<?php
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
define( 'DB_NAME', 'dermacode_db' );

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
define('AUTH_KEY',         '4ksdKzhsS|wP/7sMfe,{fi@L^0mL5NqyYc+e:?J,)MEqv6$mq`1-n0Ac))6 H{Vo');
define('SECURE_AUTH_KEY',  'x-?TUvXI@ZI}HV(h}0Vlu;SD7 LX?h;_Ctio&Jy$3>Q*[KAaO3+yy:~~a7E(_!u:');
define('LOGGED_IN_KEY',    'G|/%]udC5f._3muItR@>K,9[a6gvs|Aj R#2}90K$i#9-.ce vtvNptSle`hA62k');
define('NONCE_KEY',        ';ap{r:!}&{-w DIvON, 4Xgk[1AL^ynOil5U9-y0Es^%#-@se+jhq@9pIr{qk/>i');
define('AUTH_SALT',        'b,U^><]F5|/hEjN>70I6Jkyb~0_VtYXWXC[f3:CyavhF`>55EM546<sSS$ =(1Ag');
define('SECURE_AUTH_SALT', 'h_^{lz4`#Z;mvvr[%MQT29~W~;<0*vMwMXS=_/=`u$=KSZiErXiUV?eF($kM^k +');
define('LOGGED_IN_SALT',   '|l`vWjufkkHa!LK-zqoc{FYR4B@00SHSRn5T6b]Ub6-6{ZyG&c18])iGpbpTY]cK');
define('NONCE_SALT',       'f@&S5[;{|JH;&zO-Xf`^z1dr%-+N|0l] |%+HDzyb#FsqD@8,;WZC7Tow)F#BpKp');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */

// Disable FTP for local development
define('FS_METHOD', 'direct');

// Additional file permissions for Elementor
define('FS_CHMOD_DIR', 0755);
define('FS_CHMOD_FILE', 0644);
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Define WordPress URL and Site URL
define('WP_HOME', 'http://localhost/dermacode');
define('WP_SITEURL', 'http://localhost/dermacode');

// Fix for REST API and Gutenberg editor
define('WP_REST_API_ENABLED', true);
define('CONCATENATE_SCRIPTS', false);



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';