<?php
// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( 'Direct Access to '.__FILE__.' is not allowed.' );
// ################################################################



jr_define('_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITPRICES',"Set prices manually");
jr_define('_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITMINDAYS',"Set minimum days manually");
jr_define('_JOMRES_MICROMANAGE_PICKER_SETMINDAYS',"Set minimum days");

jr_define('_JOMRES_MICROMANAGE_PICKER_TYPE_DOW',"Set rates by day of week");
jr_define('_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_RATES',"Set rates by date interval");
jr_define('_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_MINDAYS',"Set minimum days by date interval");

jr_define('_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_RATES',"The date pickers and the rate input allow you to set one price for a given date range. Choose a start and end date, input a price, and click the Set Rates button.");
jr_define('_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_MINDAYS',"The date pickers and the minimum days input allow you to set one value for the minimum days for a given date range. Choose a start and end date, input a number for the minimum days, and click the 'Set minimum days'.");

jr_define('_JOMRES_MICROMANAGE_PICKERS_SELECTOR_INFO',"Use this dropdown to change between setting prices for individual dates, to setting minimum days for individual dates. You can use the 'by day of week' picker, the 'by date range' picker or set the prices/minimum days by manually editing the dates.");
jr_define('_JOMRES_MICROMANAGE_PICKERS_SELECTOR',"Choose whether to set prices or minimum days");

jr_define('_JOMRES_MICROMANAGE_PICKER_BYDOW',"Set minimum days by day of week");
jr_define('_JOMRES_MICROMANAGE_PICKER_BYDOW_INFO',"The day of week fields allow you to set a minimum number of days for a given day of week, once you click the day of week button all days of the week will be set to that min days setting.");
?>