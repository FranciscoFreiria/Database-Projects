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
$data = $_REQUEST['timee'];
$sql = "SELECT name, VAT FROM client WHERE name='$name' AND VAT='$numero'";
echo("<p>$sql</p>");
$result = $connection->query($sql);
$nrows = $result->rowCount();
if ($nrows == 0)
{
echo("<p>Not registered.</p>");
$sql1 = "INSERT INTO client (VAT, name) VALUES ('$numero','$name')";
$result1 = $connection->exec($sql1);
echo("<p>$sql1</p>");
echo("<p>$result1</p>");
}

else
{
echo("<table border=\"1\">");
echo("<tr><td>VAT</td><td>name</td><td>INFO</td></tr>");
foreach($result as $row)
{
$VAT_client = $row['VAT'];
$nome = $row['name'];
echo("<tr><td>");
echo($row['VAT']);
echo("</td>");
echo("<td>");
echo($row['name']);
echo("</td>");
echo("<td><a href=\"appointment_info.php?VAT_client='$numero'");
echo("\">Appointments INFO</a></td>\n");
echo("</tr>");
}
echo("</table>");
}

$sql2 = "SELECT * FROM doctor WHERE VAT NOT IN (SELECT VAT_Doctor FROM appointment WHERE date_timestamp = '$data')";
echo("<p>$sql2</p>");
$result2 = $connection->query($sql2);

echo("<table border=\"1\">");
echo("<tr><td>VAT</td><td>appointment</td></tr>");
foreach($result2 as $row)
{
$doctor = $row['VAT'];
echo("<tr><td>");
echo($row['VAT']);
echo("</td>");
echo("<td><a href=\"desc.php?VAT_Doctor='$doctor'&VAT_client='$numero'&date_timestamp='$data'");
echo("\">New appointment</a></td>\n");
echo("</tr>");
}
echo("</table>");


 $connection = null;
?>
 </body>
</html>

