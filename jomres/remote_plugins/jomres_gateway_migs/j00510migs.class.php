<?php
/**
 * @version		$Id: osdcs $
 * @package		migs
 * @copyright	Copyright (C) 2005 - 2010 osdcs.com. All rights reserved.
 *              see COPYRIGHT.php
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
// ################################################################
if (defined('JPATH_BASE'))
	defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
else
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################

class j00510migs {
	function j00510migs()
		{
		global $ePointFilepath,$eLiveSite,$itemId,$jomresConfig_live_site,$jomresConfig_absolute_path, $mosConfig_absolute_path,$mosConfig_lang;

		if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents = jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch) {
			$this->template_touchable = false;
			return;
		}

		$plugin="migs";
		$button="<IMG SRC=\"".$eLiveSite."/j00510".$plugin.".gif\" border=\"0\">";
		$defaultProperty=getDefaultProperty();

		$yesno = array();
		$yesno[] = jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO, $language,FALSE) );
		$yesno[] = jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES, $language,FALSE) );
		$curr=array('AED'=>'784','AFN'=>'971','ALL'=>'8','AMD'=>'51','ANG'=>'532','AOA'=>'973','ARS'=>'32','AUD'=>'36','AWG'=>'533','AZN'=>'944','BAM'=>'977','BBD'=>'52','BDT'=>'50','BGN'=>'975','BHD'=>'48','BIF'=>'108','BMD'=>'60','BND'=>'96','BOB'=>'68','BRL'=>'986','BSD'=>'44','BTN'=>'64','BWP'=>'72','BYR'=>'974','BZD'=>'84','CAD'=>'124','CDF'=>'976','CHF'=>'756','CLP'=>'152','CNY'=>'156','COP'=>'170','CRC'=>'188','RSD'=>'941','CUP'=>'192','CVE'=>'132','CYP'=>'196','CZK'=>'203','DJF'=>'262','DKK'=>'208','DOP'=>'214','DZD'=>'12','EEK'=>'233','EGP'=>'818','ERN'=>'232','ETB'=>'230','EUR'=>'978','FJD'=>'242','FKP'=>'238','GBP'=>'826','GEL'=>'981','GHC'=>'288','GIP'=>'292','GMD'=>'270','GNF'=>'324','GTQ'=>'320','GYD'=>'328','HKD'=>'344','HNL'=>'340','HRK'=>'191','HTG'=>'332','HUF'=>'348','IDR'=>'360','ILS'=>'376','INR'=>'356','IQD'=>'368','IRR'=>'364','ISK'=>'352','JMD'=>'388','JOD'=>'400','JPY'=>'392','KES'=>'404','KGS'=>'417','KHR'=>'116','KMF'=>'174','KPW'=>'408','KRW'=>'410','KWD'=>'414','KYD'=>'136','KZT'=>'398','LAK'=>'418','LBP'=>'422','LKR'=>'144','LRD'=>'430','LSL'=>'426','LTL'=>'440','LVL'=>'428','LYD'=>'434','MAD'=>'504','MDL'=>'498','MGA'=>'969','MKD'=>'807','MMK'=>'104','MNT'=>'496','MOP'=>'446','MRO'=>'478','MTL'=>'470','MUR'=>'480','MVR'=>'462','MWK'=>'454','MXN'=>'484','MYR'=>'458','MZN'=>'943','NAD'=>'516','NGN'=>'566','NIO'=>'558','NOK'=>'578','NPR'=>'524','NZD'=>'554','OMR'=>'512','PAB'=>'590','PEN'=>'604','PGK'=>'598','PHP'=>'608','PKR'=>'586','PLN'=>'985','PYG'=>'600','QAR'=>'634','RON'=>'946','RUB'=>'643','RWF'=>'646','SAR'=>'682','SBD'=>'90','SCR'=>'690','SDG'=>'938','SEK'=>'752','SGD'=>'702','SHP'=>'654','SIT'=>'705','SKK'=>'703','SLL'=>'694','SOS'=>'706','SRD'=>'968','STD'=>'678','SYP'=>'760','SZL'=>'748','THB'=>'764','TJS'=>'972','TMM'=>'795','TND'=>'788','TOP'=>'776','TRY'=>'949','TTD'=>'780','TWD'=>'901','TZS'=>'834','UAH'=>'980','UGX'=>'800','USD'=>'840','UYI'=>'940','UZS'=>'860','VEB'=>'862','VND'=>'704','VUV'=>'548','WST'=>'882','XAF'=>'950','XAG'=>'961','XAU'=>'959','XBA'=>'955','XBB'=>'956','XBC'=>'957','XBD'=>'958','XCD'=>'951','XDR'=>'960','XFO'=>'','XFU'=>'','XOF'=>'952','XPD'=>'964','XPF'=>'953','XPT'=>'962','XTS'=>'963','XXX'=>'999','YER'=>'886','YUM'=>'891','ZAR'=>'710','ZMK'=>'894','ZWD'=>'716');
		$currarr=array();
		foreach($curr as $value=>$key)
		{
		 $currarr[]=jomresHTML::makeOption( $key, jr_gettext($value,$value,TRUE));
		}

		$query="SELECT setting,value FROM #__jomres_pluginsettings WHERE prid LIKE '$defaultProperty' AND plugin LIKE '$plugin' ";
		$settingsList=doSelectSql($query);
		foreach ($settingsList as $set)
			{
				$settingArray[$set->setting]=$set->value;
			}
			
		$output['GATEWAYNAME']=jr_gettext('OSDCS_MAYBARKAND_NAME', ucwords($plugin),true,true);
		$output['GATEWAYLOGO']=$button;
		$output['GATEWAY']=$plugin;
		$output['ACTIVE_HELP']=OSDCS_MIGS_ACTIVE;
		$output['ACTIVE'] = jomresHTML::selectList( $yesno, 'active', 'class="inputbox" size="1"', 'value', 'text', $settingArray['active'] );
		$output['ACTIVE_HELP_DESC']=OSDCS_MIGS_ACTIVE_HELP;

		$output["ACCESSCODE_HELP"]=OSDCS_JOMRES_MIGS_ACCESSCODE;
		$output["ACCESSCODE"]=$settingArray["accesscode"];
		$output["ACCESSCODE_HELP_DESC"]=OSDCS_JOMRES_MIGS_ACCESSCODE_HELP;

		$output["MERCHANTID_HELP"]=OSDCS_JOMRES_MIGS_MERCHANTID;
		$output["MERCHANTID"]=$settingArray["merchantid"];
		$output["MERCHANTID_HELP_DESC"]=OSDCS_JOMRES_MIGS_MERCHANTID_HELP;

		$output["LOCALE_HELP"]=OSDCS_JOMRES_MIGS_LOCALE;
		$output["LOCALE"]=$settingArray["locale"];
		$output["LOCALE_HELP_DESC"]=OSDCS_JOMRES_MIGS_LOCALE_HELP;

		$output["CURRENCY_HELP"]=OSDCS_JOMRES_MIGS_CURRENCY;
		$output["CURRENCY"]=jomresHTML::selectList( $currarr, 'currencycode', 'class="inputbox" size="1"', 'value', 'text', $settingArray['currencycode'] );
		$output["CURRENCY_HELP_DESC"]=OSDCS_JOMRES_MIGS_CURRENCY_HELP;

		$output["SECURE_HELP"]=OSDCS_JOMRES_MIGS_SECURE;
		$output["SECURE"]=$settingArray["secure"];
		$output["SECURE_HELP_DESC"]=OSDCS_JOMRES_MIGS_SECURE_HELP;

		$output["RETURL_HELP"]=OSDCS_JOMRES_MIGS_RETURL;
		$output["RETURL"]=$settingArray["returl"];
		$output["RETURL_HELP_DESC"]=OSDCS_JOMRES_MIGS_RETURL_HELP;

		$output["REFURL_HELP"]=OSDCS_JOMRES_MIGS_REFURL;
		$output["REFURL"]=$settingArray["refurl"];
		$output["REFURL_HELP_DESC"]=OSDCS_JOMRES_MIGS_REFURL_HELP;

		$output["USEFAX"]=jomresHTML::selectList( $yesno, 'usefax', 'class="inputbox" size="1"', 'value', 'text', $settingArray['usefax'] );;
		$output["USEFAX_HELP"]=OSDCS_JOMRES_MIGS_USEFAX;
		$output["USEFAX_HELP_DESC"]=OSDCS_JOMRES_MIGS_USEFAX_HELP;

		$output["FAXFIELDNAME"]=$settingArray["faxfieldname"];
		$output["FAXFIELDNAME_HELP"]=OSDCS_JOMRES_MIGS_FAXFIELDNAME;
		$output["FAXFIELDNAME_HELP_DESC"]=OSDCS_JOMRES_MIGS_FAXFIELDNAME_HELP;

		$output["_HELP"]=OSDCS_JOMRES_MIGS_;
		$output[""]=$settingArray[""];

		$output['TEST_HELP']=OSDCS_MIGS_TEST;
		$output['TEST']= jomresHTML::selectList( $yesno, 'test', 'class="inputbox" size="1"', 'value', 'text', $settingArray['test'] );
		$output['TEST_HELP_DESC']=OSDCS_MIGS_TEST_HELP;
//		$settingArray['test'];			
//		$output['JOMRESTOKEN'] ='<input type="hidden" name="jomrestoken" value="'.jomresSetToken().'"><input type="hidden" name="no_html" value="1">';
		$output['JOMRESTOKEN'] ='<input type="hidden" name="no_html" value="1">';

		$pageoutput[]=$output;
		$tmpl = &new patTemplate();
		$tmpl->setRoot( $ePointFilepath );
		$tmpl->readTemplatesFromInput( 'j00510'.$plugin.'.html' );
		$tmpl->addRows( 'edit_gateway', $pageoutput );
		$tmpl->displayParsedTemplate();
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}


?>
