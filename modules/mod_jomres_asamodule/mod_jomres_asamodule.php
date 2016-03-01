<?php

// ################################################################
defined( '_JEXEC' ) or die();
if (!defined('_JOMRES_INITCHECK'))
	define('_JOMRES_INITCHECK', 1 );
// ################################################################

require_once('jomres/core-plugins/alternative_init/alt_init.php');

$our_task = $params->get('jomres_task', '');
$arguments = $params->get('arguments','');
if ($arguments!='')
	{
	$args_array = explode("&",$arguments);
	foreach ($args_array as $arg)
		{
		$vals = explode ("=",$arg);
		if(array_key_exists(1,$vals))
			{
			$_REQUEST[$vals[0]]=$vals[1];
			$_GET[$vals[0]]=$vals[1];
			}
		}
	}
	
$MiniComponents =jomres_getSingleton('mcHandler');
set_showtime('task',$our_task);
$MiniComponents->specificEvent('06000',$our_task);

?>