<?php
ob_start("ob_gzhandler");
header('Content-Type: application/json');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/_content.php');
$json_content = json_encode($services);
// Output the JSON string.
echo $json_content;
?>