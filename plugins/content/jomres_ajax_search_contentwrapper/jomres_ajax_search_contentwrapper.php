<?php

// No direct access.
defined('_JEXEC') or die;

class plgContentJomres_ajax_search_contentwrapper extends JPlugin
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
		if ($context == 'com_finder.indexer') {
			return true;
		}
		
		if (is_object($row)) {
			return $this->_wrap($row->text, $params);
		}
		return $this->_wrap($row, $params);
	}




	protected function _wrap(&$text)
		{
		
		$text = '<div id="asamodule_search_results">'.$text.'</div>';
		return true;

/*
		$pos = strpos($text, '<p');
			if ($pos == true) {
			$text = '<div id="asamodule_search_results">'.$text.'</div>';
			}
*/
		}

}
