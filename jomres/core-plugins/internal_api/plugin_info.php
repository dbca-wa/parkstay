<?php
class plugin_info_internal_api
	{
	function plugin_info_internal_api()
		{
		$this->data=array(
			"name"=>"internal_api",
			"version"=>"0.3",
			"description"=> "Provides simple function calls that allow outside scripts to call Jomres functionality. See the manual page for more information, or read /jomres/core_plugins/internal_api/internal_api.php.",
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"lastupdate"=>"2012/09/18",
			"min_jomres_ver"=>"6.6.6",
			"manual_link"=>'',
			'change_log'=>'v0.3 added a feature get the last entered review.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
?>