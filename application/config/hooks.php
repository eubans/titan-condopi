<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
								'class'    => 'Hook_Config',
								'function' => 'load_config',
								'filename' => 'Hook_Config.php',
								'filepath' => 'hooks',
								'params'   => array()
							);