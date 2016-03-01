<?php

// No direct access.
defined('_JEXEC') or die;

class plgContentJomres_asamodule_mambot extends JPlugin
{
	/**
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	mixed	An object with a "text" property.
	 * @param	array	Additional parameters. 
	 * @param	int		Optional page number. Unused. Defaults to zero.
	 * @return	boolean	True on success.
	 */
	public function onContentPrepare($context, &$row, &$params, $page = 0)
		{
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') 
			{
			return true;
			}
		
		if (is_object($row)) 
			{
			return $this->_replace($row->text, $params);
			}
		return $this->_replace($row, $params);
		}


	protected function _replace(&$text)
		{
		if (isset($text) )
			{
			if ( strpos( $text, 'asamambot' ) === false )
				{
				return true;
				}
			}
		else
			{
			return true;
			}
		
	
		
	if (!defined('_JOMRES_INITCHECK'))
		define('_JOMRES_INITCHECK', 1 );
	
	
	if (!defined('JOMRES_RETURNDATA'))
		define("JOMRES_RETURNDATA",1);
	
	require_once('jomres/core-plugins/alternative_init/alt_init.php');
	
	// {asamambot remoteavailability "&id=1"}
	// expression to search for
	$regex = '/{asamambot\s*.*?}/i';

	// find all instances of mambot and put in $matches
	preg_match_all( $regex, $text, $matches );

	if (count($matches)>0)
		{
		foreach ($matches[0] as $m)
			{
			ob_start();
			$match = str_replace(array("{","}"),"",$m);
			$match = str_replace("&amp;","&",$match);
			$bang = explode (" ",$match);
			$our_task = $bang[1];
			$arguments = $bang[2];


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
			

			$contents = ob_get_contents();
			
			$text = str_replace($m,$contents, $text);
			
			unset($contents);
			ob_end_clean();
			}
		}
	
	return true;
	}
}
