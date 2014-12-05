<?php

// every page needs to start with these basic things

// I'm using a separate config file. so pull in those values
require("config.inc.php");

// pull in the file with the database class
require("Database.class.php");

// create the $db ojbect
$db = new Database($config['server'], $config['user'], $config['pass'], $config['database'], $config['tablePrefix']);


// connect to the server
$db->connect();

if (isset($_POST[submit_product])) {


#####
// your main code would go here
#####


// insert a new record using query_insert() 

$data['title'] = $_POST[title]; 
$data['image'] = $_POST[image]; // query_insert() will auto escape it for us 
$data['shortdesc'] = $_POST[shortdesc]; 
$data['longdesc'] = $_POST[longdesc]; 
$data['cost'] = $_POST[cost]; 

// query_insert() parameters 
//     table name (no prefix) 
//     assoc array with data (doesn't need escaped) 
$db->query_insert("products", $data); 

// would create the query: 
// INSERT INTO `logs` (`count`,`ename`,`url`) VALUES ('1', 'your\'re', 'ricocheting.com'



echo "send sucess<a href=admin.php>Send Other</a>";

} elseif(isset($_POST[submit_upload])) {


      include('SimpleImage.php');
      $image = new SimpleImage();
      $image->load($_FILES['uploaded_image']['tmp_name']);
      //$image->resizeToWidth(150);
      $image->save("gallery/".$_POST[nameit].".jpg");
      //$image->output();
 echo "upload sucess in gallery folder
<a href=admin.php>continue</a>";


}  else {
?>
add new product
<form method=post action="admin.php">
<input type=text name=title>title<br>
<input type=text name=image value="jazzmaster">img name (withot extension) NOT .jpg, .gif, .png. Just The Name of the img<br>
<input type=text name=shortdesc>shotrdesc<br>
<input type=text name=longdesc>longdesc<br>
<label>
<input name="none" type="text" id="none" value="$" size="1" disabled/>
</label>
<input name=cost type=text value="0.00" size="14">
cost (solo numeros) <br>
<input type=submit name="submit_product" value="Send">
</form>
<p>
   <form action="admin.php" method="post" enctype="multipart/form-data">
      <input type="text" name="nameit" value="My IMG NAME"/>
      <input type="file" name="uploaded_image" />
      <input type="submit" name="submit_upload" value="Upload IMG/SCREENSHOT" /> REAL SIZE
   </form>
<?php

}

// ------



// Ventas completadas

ECHO "Ventas completadas<p>";

$sql = "SELECT id, total, products, shopping_cart, session_id, client_info FROM process ORDER BY id DESC "; 

$countRows = $db->query($sql); 

echo "<table width=100%>";

while ($countRow = $db->fetch_array($countRows)) { 
    echo "<tr><td>ID: $countRow[id]</td> 
          <td>TOTAL: $countRow[total]</td> 
          <td>PRODUCTS: $countRow[products]</td>
		            <td>SHOPPING CART CONTENT: $countRow[shopping_cart]</td>
					          <td>SESSION: $countRow[session_id]</td>
							            <td>CLIENT INFO: $countRow[client_info] [<a href=admin.php?op=complet&id=$countRow[id]&session_id=$countRow[session_id]>Venta Completada</a>]</td></tr>"; 
} 
echo "</table>";



// Ventas Incompletas

ECHO "Ventas Incompletas<p>";

$sql = "SELECT id, product_id, session_id, title, cost, type FROM stock ORDER BY id ASC "; 

$countRows = $db->query($sql); 

echo "<table width=100%>";

while ($countRow = $db->fetch_array($countRows)) { 
    echo "<tr><td>ID: $countRow[id]</td> 
          <td>TOTAL: $countRow[product_id]</td> 
          <td>PRODUCTS: $countRow[session_id]</td>
		            <td>SHOPPING CART CONTENT: $countRow[title]</td>
					          <td>SESSION: $countRow[cost]</td>
							  <td><a href=admin.php?op=incomplet&id=$countRow[id]&session_id=$countRow[session_id]>Borrar</a>(puede que el usuario aun pueda estar comprando)</td></tr>"; 
} 
echo "</table>";


if ($_GET[op] == "complet") {
// delete a specific entry 

$sql = "DELETE FROM process WHERE id='$_GET[id]'"; 
$db->query($sql); 

$sqluser = "DELETE FROM stock WHERE session_id='$_GET[session_id]'"; 
$db->query($sqluser); 

echo "ID: $_GET[id] ha sido borrado por que se completo la compra.";

}

if ($_GET[op] == "incomplet") {
// delete a specific entry 

$sql = "DELETE FROM stock WHERE id='$_GET[id]'"; 
$db->query($sql); 

echo "ID: $_GET[id] ha sido borrado por que NO se completo la compra.";

}


// and you're done, remember to close connection
$db->close();

echo "<a href=admin.php>Go Home</a>";

?>