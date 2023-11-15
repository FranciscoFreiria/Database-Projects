<html>
 <body>
<?php
$host = "db.tecnico.ulisboa.pt";
$user = "ist197236";
$pass = "krpc5961";
$dsn = "mysql:host=$host;dbname=$user";
try
{
$connection = new PDO($dsn, $user, $pass);
}
catch(PDOException $exception)
{
echo("<p>Error: ");
echo($exception->getMessage());
echo("</p>");
exit();
}
$name = $_REQUEST['nome'];
$numero = $_REQUEST['VAT'];
$data = $_REQUEST['timestamp'];
$sql = "SELECT name, VAT FROM client WHERE name='$name' AND VAT='$numero'";
$sql2 = "SELECT * FROM doctor WHERE VAT NOT IN (SELECT VAT_Doctor FROM appointment WHERE date_timestamp = '$timestamp')";
echo("<p>$sql2</p>");
$result2 = $connection->query($sql2);
echo("<p>$sql</p>");
$result = $connection->query($sql);
$nrows = $result->rowCount();
if ($nrows == 0)
{
echo("<p>Not registered.</p>");
$sql1 = "INSERT INTO client (VAT, name) VALUES ('$numero','$name')";
echo("<p>$sql1</p>");
$result1 = $connection->exec($sql1);
}
else
{
$row = $result->fetch();
$olha = $row['name'];
echo("<p>Matching names is: $olha</p>");
}
echo("<table border=\"1\">");
echo("<tr><td>VAT</td><td>name</td></tr>");
foreach($result2 as $row)
{
echo("<tr><td>");
echo($row['VAT']);
echo("</td><td>");
echo($row['name']);
echo("</td>");
echo("<td><a href=\"desc.php?VAT_Doctor=?");
echo($row['VAT_Doctor']);
echo("\">New appointment</a></td>\n");
echo("</td></tr>");
}
echo("</table>");


 $connection = null;
?>
 <p><input type="submit" value="Submit"/></p>
 </body>
</html>
