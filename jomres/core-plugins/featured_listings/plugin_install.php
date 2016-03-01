<?php
// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

if (!defined('JOMRES_INSTALLER')) exit;

$query = "CREATE TABLE IF NOT EXISTS `#__jomresportal_featured_properties` (
  `property_uid` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  PRIMARY KEY  (property_uid)
)";
doInsertSql($query,"");
?>