<html>
 <body>
 <form action="appointment_spec.php" method="post">
 <p><input type="hidden" name="VAT_client" value="<?=$_REQUEST['VAT']?>"/></p>
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
$name = $_REQUEST['VAT'];
echo("<p>$name</p>");
$sql = "SELECT date_timestamp FROM appointment natural join consultation  WHERE VAT_client = '$name'";
$result = $connection->query($sql);
echo("<p>$sql</p>");
echo("<table border=\"1\">");
echo("<tr><td>date</td><td>INFO</td></tr>");
foreach($result as $row)
{
echo("<tr><td>");
echo($row['date_timestamp']);
echo("</td>");
echo("<td><a href=\"appointment_spec.php?date_timestamp='$row[date_timestamp]'&VAT_client='$name'");

echo("\">INFO</a></td>\n");
echo("</td></tr>");
}
echo("</table>");
$connection = null;
?>
 </body>
</html>