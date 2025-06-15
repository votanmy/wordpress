<?php
// Prevent direct access
if (php_sapi_name() !='cli') exit;

if( file_exists('posts_data.txt') ){
	unlink('posts_data.txt');
}
if( file_exists('products_data.txt') ){
	unlink('products_data.txt');
}
if( file_exists('relations_data.txt') ){
	unlink('relations_data.txt');
}
if( file_exists('space_data.txt') ){
	unlink('space_data.txt');
}
if( file_exists('mapping_data.txt') ){
	unlink('mapping_data.txt');
}