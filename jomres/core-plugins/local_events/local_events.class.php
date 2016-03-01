<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class local_events
	{
	function local_events()
		{
		$this->local_eventsConfigOptions=array();
		$this->local_eventsConfigOptions['radius']="10";
		}
	
	function get_local_events_settings()
		{
		$query="SELECT setting,value FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = 'local_events'";
		$settingList=doSelectSql($query);
		foreach ($settingList as $s)
			{
			$this->local_eventsConfigOptions[$s->setting]=$s->value;
			}
		return $this->local_eventsConfigOptions;
		}

	function save_local_events_settings()
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
			$query="SELECT id FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = 'local_events' AND setting = '$k'";
			$settingList=doSelectSql($query);
			if (count($settingList)>0)
				{
				foreach ($settingList as $set)
					{
					$id=$set->id;
					}
				$query="UPDATE #__jomres_pluginsettings SET `value`='$v' WHERE prid = 0 AND plugin = 'local_events' AND setting = '$k'";
				doInsertSql($query,"");
				}
			else
				{
				$query="INSERT INTO #__jomres_pluginsettings
					(`prid`,`plugin`,`setting`,`value`) VALUES
					(0,'local_events','$k','$v')";
				doInsertSql($query,"");
				}
			}
		}
		
	function find_items_within_range_for_property_uid($item_type = "local_events",$property_uid)
		{
		$current_property_details =jomres_singleton_abstract::getInstance('basic_property_details');
		$current_property_details->gather_data($property_uid);
		
		if ($item_type == "local_events")
			{
			$table = "#__jomres_local_events";
			$date_cols = "`start_date`,`end_date`,";
			$icon = "";
			}
		else
			{
			$table = "#__jomres_local_attractions";
			$date_cols = "";
			$icon = "`icon`,";
			}
		
		$query ="SELECT `id`,`title`,".$icon."`website_url`,`event_logo`,`description`, ".$date_cols." ( ((ACOS(SIN(".$current_property_details->lat." * PI() / 180) * SIN(`latitude` * PI() / 180) + COS(".$current_property_details->lat." * PI() / 180) * COS(`latitude` * PI() / 180) * COS((".$current_property_details->long." - `longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) * 1.609344 ) AS distance FROM ".$table." HAVING distance<='".$this->local_eventsConfigOptions['radius']."' ORDER BY distance ASC";
		$result = doSelectSql($query);
		return $result;
		}
		
	}
?>