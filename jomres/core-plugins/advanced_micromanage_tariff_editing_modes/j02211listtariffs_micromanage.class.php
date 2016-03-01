<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################


/**
#
 * Constructs and displays tariff list
 #
* @package Jomres
#
 */
class j02211listtariffs_micromanage {
	/**
	#
	 * Constructor: Constructs and displays tariff list - admin side
	#
	 */
	function j02211listtariffs_micromanage()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		$ePointFilepath=get_showtime('ePointFilepath');
		$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		$defaultProperty=getDefaultProperty();
	 	if ($jrConfig['useGlobalRoomTypes']=="1")
			$roomTypeSearchParameter="0";
		else
			$roomTypeSearchParameter=$defaultProperty;

		$query="SELECT `id`,`name` FROM #__jomcomp_tarifftypes WHERE property_uid = '".(int)$defaultProperty."'";
		$tariffList =doSelectSql($query);
		foreach($tariffList as $tariff)
			{
			$rw=array();
			$tariff_type_id = $tariff->id;
			$query="SELECT tariff_id,roomclass_uid FROM #__jomcomp_tarifftype_rate_xref WHERE tarifftype_id = '".(int)$tariff->id."' LIMIT 1";
			$tariffRoomClass =doSelectSql($query,2);
			$query="SELECT mindays,maxdays,minpeople,maxpeople FROM #__jomres_rates WHERE rates_uid = '".(int)$tariffRoomClass['tariff_id']."' LIMIT 1";
			$tariffDetails =doSelectSql($query,2);
			$roomClassAbbv="";
			if ($tariffRoomClass!="")
				{
				$rmClassId=$tariffRoomClass['roomclass_uid'];
				$query="SELECT room_class_abbv FROM #__jomres_room_classes WHERE room_classes_uid = '".(int)$rmClassId."' AND property_uid = '".(int)$roomTypeSearchParameter."'";
				$classList =doSelectSql($query);
				foreach($classList as $rclass)
					{
					//$roomClassAbbv=$rclass->room_class_abbv;
					$roomClassAbbv = jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV'.(int)$rmClassId,		stripslashes($rclass->room_class_abbv),false,false);
					}
				}

			$jrtbar =jomres_singleton_abstract::getInstance('jomres_toolbar');
			$jrtb  = $jrtbar->startTable();
			$jrtb .= $jrtbar->toolbarItem('edit',jomresURL(JOMRES_SITEPAGE_URL."&task=editTariff&tarifftypeid=".($tariff->id) ),'');
			$jrtb .= $jrtbar->toolbarItem('copy',jomresURL(JOMRES_SITEPAGE_URL."&task=editTariff&tarifftypeid=".($tariff->id)."&clone=1"),'');
			$jrtb .= $jrtbar->endTable();
			$rw['LINKTEXT']=$jrtb;
			
			$rw['EDIT_URL']=jomresURL(JOMRES_SITEPAGE_URL."&task=editTariff&tarifftypeid=".$tariff->id );
			$rw['COPY_URL']=jomresURL(JOMRES_SITEPAGE_URL."&task=editTariff&tarifftypeid=".$tariff->id."&clone=1");
			$rw['DELETE_URL']=jomresURL(JOMRES_SITEPAGE_URL."&task=deleteTariff&tarifftypeid=".$tariff->id);
			
			$rw['RATETITLE']			=$tariff->name;
			$rw['RATETITLE']			=jr_gettext('_JOMRES_CUSTOMTEXT_TARIFF_TITLE_TARIFFTYPE_ID'.$tariff_type_id,stripslashes($tariff->name));
			$rw['MINDAYS']				=$tariffDetails['mindays'];
			$rw['MAXDAYS']				=$tariffDetails['maxdays'];
			$rw['MINPEOPLE']			=$tariffDetails['minpeople'];
			$rw['MAXPEOPLE']			=$tariffDetails['maxpeople'];
			$rw['ROOMCLASS']			=$roomClassAbbv;
			$rows[]=$rw;
			}
		$output['HLINKTEXT']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_LINKTEXT',_JOMRES_COM_MR_LISTTARIFF_LINKTEXT,false);
		//$output['HLINKTEXTCLONE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_LINKTEXTCLONE',_JOMRES_COM_MR_LISTTARIFF_LINKTEXTCLONE);
		$output['HRATETITLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE,false) ;
		$output['HMINDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS,false);
		$output['HMAXDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS,false);
		$output['HMINPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE,false);
		$output['HMAXPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE,false);
		$output['HROOMCLASS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS,false);

		$jrtbar =jomres_singleton_abstract::getInstance('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('new',jomresURL(JOMRES_SITEPAGE_URL."&task=editTariff"),'');
		$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL(JOMRES_SITEPAGE_URL),'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['pagetitle']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_TITLE',_JOMRES_COM_MR_LISTTARIFF_TITLE,false);
		$output['JOMRES_SITEPAGE_URL']=JOMRES_SITEPAGE_URL;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'list_micromanage_tariffs.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows', $rows );
		$this->tpl=$tmpl->getParsedTemplate();
		}

	function touch_template_language()
		{
		$output=array();
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_LINKTEXT',_JOMRES_COM_MR_LISTTARIFF_LINKTEXT);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE) ;
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_TITLE',_JOMRES_COM_MR_LISTTARIFF_TITLE);

		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	/**
	#
	 * Must be included in every mini-component
	#
	 * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
	#
	 */
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->tpl;
		}
	}
