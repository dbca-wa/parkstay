<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class jrportal_extended_maps
	{
	function jrportal_extended_maps()
		{
		$this->extended_mapsConfigOptions=array();
		$this->extended_mapsConfigOptions['width']="600";
		$this->extended_mapsConfigOptions['height']="400";
		$this->extended_mapsConfigOptions['maptype']="normal";
		$this->extended_mapsConfigOptions['overrideplist']="1";
		$this->extended_mapsConfigOptions['groupmarkers']="1";
		$this->extended_mapsConfigOptions['srpicon']="/jomres/core-plugins/extended_maps/markers/house.png";
		$this->extended_mapsConfigOptions['mrpicon']="/jomres/core-plugins/extended_maps/markers/hotel.png";
		$this->extended_mapsConfigOptions['infoicon']="/jomres/core-plugins/extended_maps/markers/info.png";
		$this->extended_mapsConfigOptions['popupwidth']="200";
		$this->extended_mapsConfigOptions['img_width']="150";
		$this->extended_mapsConfigOptions['img_height']="120";
		$this->extended_mapsConfigOptions['show_description']="1";
		$this->extended_mapsConfigOptions['trim_description']="1";
		$this->extended_mapsConfigOptions['trim_value']="100";
		}
	
	function get_extended_maps()
		{
		$query="SELECT setting,value FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = 'extended_maps'";
		$settingList=doSelectSql($query);
		foreach ($settingList as $s)
			{
			$this->extended_mapsConfigOptions[$s->setting]=$s->value;
			}
		return $this->extended_mapsConfigOptions;
		}

	function save_extended_maps()
		{
		foreach ($_POST as $k=>$v)
			{
			$dirty = (string) $k;
			$k=addslashes($dirty);
			if ($k!='task' && $k!='plugin' && $k !="option" )
				$values[$k]=jomresGetParam( $_POST, $k, "" );
			}
		foreach ($values as $k=>$v)
			{
			$query="SELECT id FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = 'extended_maps' AND setting = '$k'";
			$settingList=doSelectSql($query);
			if (count($settingList)>0)
				{
				foreach ($settingList as $set)
					{
					$id=$set->id;
					}
				$query="UPDATE #__jomres_pluginsettings SET `value`='$v' WHERE prid = 0 AND plugin = 'extended_maps' AND setting = '$k'";
				doInsertSql($query,"");
				}
			else
				{
				$query="INSERT INTO #__jomres_pluginsettings
					(`prid`,`plugin`,`setting`,`value`) VALUES
					(0,'extended_maps','$k','$v')";
				doInsertSql($query,"");
				}
			}
		}
	}
?>