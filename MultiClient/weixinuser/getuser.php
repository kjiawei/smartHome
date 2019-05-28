<?php
$q=$_GET["q"];

echo "you want to request index is ".$q." and name is ".$_GET["sid"];

$con = mysql_connect('localhost', 'root', '123456');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("mynode", $con);

//$sql="SELECT * FROM user WHERE id = '".$q."'";
$sql="SELECT * FROM weixinuser";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>id</th>
<th>name</th>
<th>openid</th>
</tr>";

while($row = mysql_fetch_array($result))
 {
 echo "<tr>";
 echo "<td>" . $row['name'] . "</td>";
 echo "<td>" . $row['email'] . "</td>";
 echo "<td>" . $row['openid'] . "</td>";
 echo "</tr>";
 }
echo "</table>";

mysql_close($con);
?>
