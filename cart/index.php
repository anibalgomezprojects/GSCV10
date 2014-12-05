<?php


// I'm using a separate config file. so pull in those values
require(CART_DIR."config.inc.php");

// pull in the file with the database class
require(CART_DIR."Database.class.php");


// create the $db ojbect
$db = new Database($config['server'], $config['user'], $config['pass'], $config['database'], $config['tablePrefix']);


// connect to the server
$db->connect();

if($_POST[buy]) {

if ($_POST[buy_submit]) {

// select

$sql = "SELECT id, product_id, session_id, title, cost, type FROM stock 
          WHERE session_id LIKE '". $db->escape($_POST[session_id]) ."%' 
          ORDER BY id DESC 
          LIMIT 0,10"; 

$countRows = $db->query($sql); 
$total_products = mysql_num_rows($countRows);
$client_info = $_POST[client_name];
$products = $total_products;

while ($countRow = $db->fetch_array($countRows)) { 

//$total
//$products
$shopping_cart = $shopping_cart.$countRow[title].", ";
$session_id = $countRow[session_id];
//$client_info

} 

$data['total'] = $_POST[total];
$data['products'] = $products;
$data['shopping_cart'] = $shopping_cart;
$data['session_id'] = $session_id;
$data['client_info'] = "Nombre: ".$_POST[client_info] ."<br>Pais: ". $_POST[client_country] ."<br>Direccion: ". $_POST[client_addr] . "<br>Cp: ".$_POST[client_cp] ."<br>Empresa: ". $_POST[client_work] ."<br><font color=red>Email: ". $_POST[client_email] ."</font><br><font color=blue>Pago: ". $_POST[client_select]."</font>";

$db->query_insert("process", $data); 

echo "Gracias! El sistema esta evaluando su compra el administrador se pondra en contacto con usted en las siguientes 24 horas para enviarle las instrucciones de compra y la descarga del producto!...<a href=index.php>Clic aqui para continuar<a>";

} else {

$total = 0;

$sql0 = "SELECT id, product_id, session_id, title, cost, type FROM stock 
          WHERE session_id LIKE '". $db->escape($_SERVER[REMOTE_ADDR]) ."%' 
          ORDER BY product_id DESC
	  LIMIT 0, 10"; 

$countRows0 = $db->query($sql0); 


while ($countRow0 = $db->fetch_array($countRows0)) { 
	  $total = $total+$countRow0[cost];
	  $products = $countRow0[product_id];
	  $title = $$countRow0[title];
} 

echo "<form method=post action=\"index.php?op=shop\">
<b>- Propocione los siguientes datos para completar su compra. <br> - Los campos con * son obligatorios. <br> - Elija tipo de pago.</b><br>
  <table width=\"460\" height=\"200\" border=\"0\" cellpadding=\"3\" cellspacing=\"3\">
  <tr>
    <th align=\"right\" scope=\"col\">Nombre</th>
    <th align=\"left\" scope=\"col\"><label>
      <input name=\"client_name\" type=\"text\" id=\"client_name\" size=\"56\" />
    *</label></th>
  </tr>
  <tr>
    <th align=\"right\" scope=\"row\">Pais/Direccion/CP</th>
    <td align=\"left\"><label>
      <input name=\"client_country\" type=\"text\" id=\"client_country\" size=\"15\" />
      *</label>      <label>
    <input name=\"client_addr\" type=\"text\" id=\"client_addr\" size=\"15\" />
    *  
    <input name=\"client_cp\" type=\"text\" id=\"client_cp\" size=\"15\">
    *</label></td>
  </tr>
  
  <tr>
    <th align=\"right\" scope=\"row\">Empresa/Trabajo</th>
    <td align=\"left\"><input name=\"client_work\" type=\"text\" id=\"client_work\" size=\"20\" />
      * Telefono
      <input name=\"client_phone\" type=\"text\" id=\"client_phone\" size=\"20\" />
    *</td>
  </tr>
  
  <tr>
    <th align=\"right\" scope=\"row\">E-mail (actual) </th>
    <td align=\"left\"><input name=\"client_email\" type=\"text\" id=\"client_email\" size=\"56\" />
    *</td>
  </tr>
  <tr>
    <th align=\"right\" scope=\"row\">Tipo de pago </th>
    <td align=\"left\"><label>
      <select name=\"client_select\">
        <option value=\"Deposito Bancario\" selected>Deposito Bancario</option>
        <option value=\"Tarjeta De Credito\">Tarjeta De Credito</option>
        <option value=\"Paypal\">Paypal</option>
        <option value=\"Trato Directo Por Telefono\">Trato Directo Por Telefono</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <th align=\"right\" scope=\"row\">Total: \$$total USD<input type=hidden name=\"total\" value=\"$total\"></th>
    <td align=\"left\"><input name=\"buy_submit\" type=\"submit\" id=\"buy\" value=\"Procesar Compra!\" /></td>
  </tr>

</table>
<!-- HIDDEN -->
	  	  <input type=hidden name=\"session_id\" value=\"$_SERVER[REMOTE_ADDR]\">
		  	  	  <input type=hidden name=\"buy\" value=\"1\">
</form>
";

}

} else {


if($_POST[view_my_cart]) {

$total = 0;

$sql0 = "SELECT id, product_id, session_id, title, cost, type FROM stock 
          WHERE session_id LIKE '". $db->escape($_SERVER[REMOTE_ADDR]) ."%' 
          ORDER BY product_id DESC
	  LIMIT 0, 10"; 

$countRows0 = $db->query($sql0); 
echo "<table width=100%>";
echo "<form method=post action=\"index.php?op=shop\">";
while ($countRow0 = $db->fetch_array($countRows0)) { 
    echo "<tr><td>ID: $countRow0[id]</td>
          <td>NAME: $countRow0[title]</td>
          <td>COSTO: $countRow0[cost]</td>
	  <td><b>$countRow0[type]</b></td></tr>
	  	  <input type=hidden name=\"product_id\" value=\"$countRow0[id]\">
		  <input type=hidden name=\"p_session_id\" value=\"$countRow0[session_id]\">
		  <input type=hidden name=\"title\" value=\"$countRow0[title]\">
		  <input type=hidden name=\"cost\" value=\"$countRow0[cost]\">
	  "; 
	  $total = $total+$countRow0[cost];
} 

$pro = "SELECT id, product_id, session_id, title, cost, type FROM stock 
          WHERE session_id LIKE '". $db->escape($_SERVER[REMOTE_ADDR]) ."%' 
          ORDER BY title DESC"; 

$tl = $db->query($pro); 

$total_products = mysql_num_rows($tl);

echo "<tr><td></td><td><B>Total:</B></td><td><b>\$$total</b> USD ($total_products productos en total) Nota: Solo se permiten 10 productos por canasta...<A HREF=# title=\"Si desea mas primero realize una compra de 10 productos y despues haga otra.\">(? + INFO)</a></td></tr></table>";
echo "<B>ESTA APUNTO DE TERMINAR SU COMPRA PROPORCIONE SUS DATOS EN LA PAGINA SIGUIENTE.</B><p><input name=\"buy\" type=\"submit\" id=\"buy\" value=\"Terminar Compra!\" /></form>";

} else {


if($_POST[add_to_cart]) {


// insert a new record using query_insert() 

$data['product_id'] = $_POST[product_id]; // query_insert() will auto escape it for us 
$data['session_id'] = $_POST[session_id];
$data['title'] = $_POST[title];
$data['cost'] = $_POST[cost];

// query_insert() parameters 
//     table name (no prefix) 
//     assoc array with data (doesn't need escaped) 
$db->query_insert("stock", $data); 

// would create the query: 
// INSERT INTO `stock` (`count`,`ename`,`url`) VALUES ('1', 'your\'re', 'ricocheting.com') 

echo "<body onload=\"javascript:alert('Nuevo productor agregado a su Carrito de Compras $_POST[title]')\"";


} // end if

if ($_POST[clean_my_cart]) {
// delete a specific entry 

$sql = "DELETE FROM stock WHERE session_id='$_SERVER[REMOTE_ADDR]'"; 
$db->query($sql); 

}// every page needs to start with these basic things


$sql1 = "SELECT product_id, session_id, title, cost FROM stock 
          WHERE session_id LIKE '". $db->escape($_SERVER[REMOTE_ADDR]) ."%' 
          ORDER BY product_id DESC 
          "; 

$countRows1 = $db->query($sql1); 

$num_rows = mysql_num_rows($countRows1);

echo "<center><form method=\"post\" action=\"index.php?op=shop\"><b><img src=\"".CART_DIR."gallery/sc.png\"><a href=#><b>($num_rows)</b></a></b> <br> <input type=submit name=\"view_my_cart\" value=\"Comprar!\" class=atc>  <input type=submit name=\"clean_my_cart\" value=\"Vaciar!\"></form></center>\n";





#####
// your main code would go here
#####



   include(CART_DIR."SimpleImage.php");
   $image = new SimpleImage();



	//Include the PS_Pagination class
	include(CART_DIR."ps_pagination.php");

	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"3\" align=center width='100%'><tr>";

	//Connect to mysql db
	$conn = mysql_connect($config['server'],$config['user'],$config['pass']);
	mysql_select_db($config['database'],$conn);
	$sql = 'SELECT * FROM products';
	

	/**
	 * Constructor
	 *
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 */

	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn,$sql,3,5);
	



	//The paginate() function returns a mysql result set 
	$rs = $pager->paginate();
	while($row = mysql_fetch_assoc($rs)) {
	   $image->load(CART_DIR."gallery/$row[image].jpg");
   $image->resize(150,95);
   $image->save(CART_DIR."gallery/$row[image]2.jpg");
   
   // get image size
   list($width, $height, $type, $attr) = getimagesize(CART_DIR."gallery/$row[image].jpg");

	echo "<td align=center>
          <a href=\"".CART_DIR."/gallery/$row[image].jpg\" target=\"_blank\" onClick=\"window.open(this.href, this.target, 'width=$width,height=$height'); return false;\">
          <img src=\"".CART_DIR."gallery/$row[image]2.jpg\" border=0 alt=\"Template ID:$row[id] Name: $row[title]\"></a>
          <br>$row[shortdesc]
          <br>$row[longdesc]
          <br><b>\$$row[cost] USD</b>
		  <form method=post action=\"index.php?op=shop\" name=\"frm_add_to_cart\">
		  <input type=hidden name=\"product_id\" value=\"$row[id]\">
		  <input type=hidden name=\"session_id\" value=\"$_SERVER[REMOTE_ADDR]\">
		  <input type=hidden name=\"title\" value=\"$row[title]\">
		  <input type=hidden name=\"cost\" value=\"$row[cost]\">
		  <input type=submit value=\"Add to cart\" name=\"add_to_cart\" class=\"atc\"></form></td>"; 
	}
	echo "</tr></table>";

	echo "<center>";
	//Display the full navigation in one go
	echo $pager->renderFullNav();
	
	//Or you can display the inidividual links
	//echo "<br />";
	
	//Display the link to first page: First
	//echo $pager->renderFirst();
	
	//Display the link to previous page: <<
	//echo $pager->renderPrev();
	
	//Display page links: 1 2 3
	//echo $pager->renderNav();
	
	//Display the link to next page: >>
	//echo $pager->renderNext();
	
	//Display the link to last page: Last
	//echo $pager->renderLast();
	echo "</center>";





// and you're done, remember to close connection
$db->close();
//} // if

} //end if (else)


} // end if buy
?>