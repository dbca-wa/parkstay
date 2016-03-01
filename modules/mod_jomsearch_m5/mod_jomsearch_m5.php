<?php
// ################################################################
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
if (!defined('_JOMRES_INITCHECK'))
    define('_JOMRES_INITCHECK', 1 );
// ################################################################

require_once(JPATH_BASE.DIRECTORY_SEPARATOR.'jomres'.DIRECTORY_SEPARATOR.'core-plugins'.DIRECTORY_SEPARATOR.'alternative_init'.DIRECTORY_SEPARATOR.'alt_init.php');

$calledByModule="mod_jomsearch_m5";
$doSearch=false;
$includedInModule=true;

if (!function_exists('jomres_getSingleton'))
{
    $MiniComponents = new mcHandler();
    $componentArgs=array('doSearch'=>$doSearch,'includedInModule'=>$includedInModule,'calledByModule'=>$calledByModule);
    $MiniComponents->triggerEvent('00030',$componentArgs);
}
else
{
    $MiniComponents =jomres_getSingleton('mcHandler');
    $componentArgs=array('doSearch'=>$doSearch,'includedInModule'=>$includedInModule,'calledByModule'=>$calledByModule);
    $MiniComponents->triggerEvent('00030',$componentArgs);
}
?>