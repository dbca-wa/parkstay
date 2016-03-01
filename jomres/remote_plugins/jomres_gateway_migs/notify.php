<html>
<body>
<?php
$tmp=explode('/jomres/',"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//print_r($tmp);
$url=$tmp[0]."/index.php?option=com_jomres&task=completebk&plugin=migs";
echo "<form name='sf' action='$url' method='POST' id='sf'>";
foreach($_REQUEST as $key=>$value)
{
	echo "<input type='hidden' name='$key' value='$value'>";
}
//echo "<input type='submit'>";
echo "</form>";
echo "\r\n<script>document.getElementById('sf').submit();</script>";
?>
</body>
</html>
