<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">
</head>
<body>

<?php

require('../dbconfig.php');

session_start();
if ($_POST['token'] == $_SESSION['customer_token'])
request();
 session_write_close();


?>



</body>
</html>