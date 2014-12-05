<html>
<head>
<title>GOMEZ SHOPPING CAR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- ImageReady Slices (optimized_1024x768.psd) -->
<table id="Tabla_01" width="1001" height="768" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3">
			<img src="Images/gsc_01.gif" width="204" height="161" alt=""></td>
		<td>
			<img src="Images/gsc_02.gif" width="589" height="161" alt=""></td>
		<td colspan="3">
			<img src="Images/gsc_03.gif" width="208" height="161" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="Images/gsc_04.gif" width="33" height="538" alt=""></td>
		<td>
			<img src="Images/gsc_05.gif" width="94" height="538" alt=""></td>
		<td>
			<img src="Images/gsc_06.gif" width="77" height="538" alt=""></td>
		<td width="589" height="538" valign="top" background="Images/gsc_07.gif" alt="">
<a href=index.php?op=shop>Go to Gomez Shopping Car</a><?php

// Here is how to call GomezShoppingCart

switch($_GET['op']) {

	case "shop";
	define("CART_DIR","cart/"); // GSC Folder. Ever SGSC in a sub folder (easy integration remember)
	include("cart/index.php");
	break;
	
}

?></td>
		<td>
			<img src="Images/gsc_08.gif" width="69" height="538" alt=""></td>
		<td>
			<img src="Images/gsc_09.gif" width="99" height="538" alt=""></td>
		<td>
			<img src="Images/gsc_10.gif" width="40" height="538" alt=""></td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="Images/gsc_11.gif" width="204" height="69" alt=""></td>
		<td>
			<img src="Images/gsc_12.gif" width="589" height="69" alt=""></td>
		<td colspan="3">
			<img src="Images/gsc_13.gif" width="208" height="69" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>