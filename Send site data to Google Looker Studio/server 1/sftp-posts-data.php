<?php
/*
Get posts data. Create posts_data.sql then SFTP to the Reporting Server
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Allows access Wordpress functions
define('WP_USE_THEMES', false);
require_once('/home/customer/www/example.com/public_html/wp-load.php');
			
$posts_data_file 	= 'posts_data.txt';

// Get posts data
require_once __DIR__ . '/get_posts_product.php';
require_once __DIR__ . '/get_posts_post.php';
require_once __DIR__ . '/get_posts_page.php';
require_once __DIR__ . '/get_posts_space.php';
require_once __DIR__ . '/get_product_categories.php';

