<html>
<head>
<title>Example page GomezStudio Shopping Cart</title>
</head>
<body>

This is your index website... example

<?php

// Here is how to call GomezShoppingCart

switch($_GET['op']) {

	case "shop";
	define("CART_DIR","cart/"); // GSC Folder. Ever SGSC in a sub folder (easy integration remember)
	include("cart/index.php");
	break;
	
}

?>
</body>
</html>