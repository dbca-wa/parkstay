<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

if (!defined('JOMRES_INSTALLER')) exit;

$query = "CREATE TABLE IF NOT EXISTS `#__jomres_local_events` (
  id int(10) NOT NULL auto_increment,
  title VARCHAR( 255 ) default 'Changeme',
  start_date DATE,
  end_date DATE,
  latitude VARCHAR( 12 ) NULL DEFAULT NULL,
  longitude VARCHAR( 12 ) NULL DEFAULT NULL,
  website_url VARCHAR(255 ) NOT NULL default '',
  event_logo VARCHAR( 255 ) NULL,
  description TEXT NULL,
  PRIMARY KEY  (id)
)";
doInsertSql($query,"");

$query = "CREATE TABLE IF NOT EXISTS `#__jomres_local_attractions` (
	id int(10) NOT NULL auto_increment,
	title VARCHAR( 255 ) default 'Changeme',
	icon VARCHAR(255 ) NOT NULL default 'info.png',
	latitude VARCHAR( 12 ) NULL DEFAULT NULL,
	longitude VARCHAR( 12 ) NULL DEFAULT NULL,
	website_url VARCHAR(255 ) NOT NULL default '',
	event_logo VARCHAR( 255 ) NULL,
	description TEXT NULL,
	PRIMARY KEY  (id)
)";

doInsertSql($query,"");

$query="SHOW COLUMNS FROM #__jomres_local_events LIKE 'description'";
$result=doSelectSql($query);
if (count($result)==0)
	{
	$query = "ALTER TABLE `#__jomres_local_events` ADD description TEXT NULL AFTER `event_logo` ";
	doInsertSql($query,'');
	}

$query="SHOW COLUMNS FROM #__jomres_local_attractions LIKE 'description'";
$result=doSelectSql($query);
if (count($result)==0)
	{
	$query = "ALTER TABLE `#__jomres_local_attractions` ADD description TEXT NULL AFTER `event_logo` ";
	doInsertSql($query,'');
	}
?>