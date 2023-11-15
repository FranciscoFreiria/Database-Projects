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
$VAT_c = $_REQUEST['VAT_client'];
$data = $_REQUEST['date_timestamp'];
echo("<p>$VAT_c</p>");
echo("<p>$data</p>");
$sql = "SELECT VAT_client FROM appointment WHERE VAT_client = $VAT_c AND date_timestamp = $data";
echo("<p>$sql</p>");
$result = $connection->query($sql);

echo("<table border=\"1\">");
echo("<tr><td>SOAP_S</td><td>SOAP_O</td></tr>");
foreach($result as $row)
{
echo("<tr><td>");
echo("{$row['VAT_client']}");
echo("</td></tr>");
}
echo("</table>");
$connection = null;
 ?>
 </body>
</html>

