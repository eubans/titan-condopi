<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slugify'))
{
	function skin_url($url="")
	{ 
		return base_url("skins/".$url."");
	}
}

if ( ! function_exists('backend_url')) {
	function backend_url($path='') {
		$url = 'backend/' . $path;
		$url = str_replace("///","/",$url);
		$url = str_replace("//","/",$url);
		return base_url($url);
	}
};

