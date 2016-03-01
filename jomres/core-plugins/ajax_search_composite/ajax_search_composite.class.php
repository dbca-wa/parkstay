<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class ajax_search_composite
	{
	function ajax_search_composite()
		{
		$this->plugin = 'ajax_search_composite';
		
		$this->ajax_search_compositeConfigOptions=array();
		$this->ajax_search_compositeConfigOptions['by_stars']		="1";
		$this->ajax_search_compositeConfigOptions['by_price']		="1";
		$this->ajax_search_compositeConfigOptions['by_features']	="1";
		$this->ajax_search_compositeConfigOptions['by_country']		="1";
		$this->ajax_search_compositeConfigOptions['by_region']		="1";
		$this->ajax_search_compositeConfigOptions['by_town']		="1";
		$this->ajax_search_compositeConfigOptions['by_roomtype']	="1";
		$this->ajax_search_compositeConfigOptions['by_propertytype']="1";
		$this->ajax_search_compositeConfigOptions['by_guestnumber']	="1";
		$this->ajax_search_compositeConfigOptions['modal']			="0";
		}

	function get()
		{
		$query="SELECT setting,value FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = '".(string)$this->plugin."'";
		$settingList=doSelectSql($query);
		foreach ($settingList as $s)
			{
			$this->ajax_search_compositeConfigOptions[$s->setting]=$s->value;
			}
		return $this->ajax_search_compositeConfigOptions;
		}

	function save()
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
			$query="SELECT id FROM #__jomres_pluginsettings WHERE prid = 0 AND plugin = '".(string)$this->plugin."' AND setting = '$k'";
			$settingList=doSelectSql($query);
			if (count($settingList)>0)
				{
				foreach ($settingList as $set)
					{
					$id=$set->id;
					}
				$query="UPDATE #__jomres_pluginsettings SET `value`='$v' WHERE prid = 0 AND plugin = '".(string)$this->plugin."' AND setting = '$k'";
				doInsertSql($query,"");
				}
			else
				{
				$query="INSERT INTO #__jomres_pluginsettings
					(`prid`,`plugin`,`setting`,`value`) VALUES
					(0,'".(string)$this->plugin."','$k','$v')";
				doInsertSql($query,"");
				}
			}
		}
	}
?>