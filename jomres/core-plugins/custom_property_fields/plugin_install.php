<?php
if (!defined('JOMRES_INSTALLER')) exit;

$query = "CREATE TABLE IF NOT EXISTS `#__jomres_custom_property_fields_fields` (
	`id` int(10) NOT NULL auto_increment,
	`fieldname` VARCHAR( 255 ) ,
	`default_value` VARCHAR( 255 ) ,
	`description` VARCHAR( 255 ) ,
	`required` BOOL NOT NULL DEFAULT '0',
	`order` INT NULL DEFAULT '0',
	`ptype_xref` text,
	PRIMARY KEY  (id)
)";
doInsertSql($query,"");

$query = "CREATE TABLE IF NOT EXISTS `#__jomres_custom_property_fields_data` (
	`id` int(10) NOT NULL auto_increment,
	`fieldname` VARCHAR( 255 ) ,
	`data` TEXT NULL,
	`property_uid` INT NULL DEFAULT '0',
	PRIMARY KEY  (id)
)";
doInsertSql($query,"");

?>