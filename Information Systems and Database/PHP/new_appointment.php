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
$desc = $_REQUEST['desc'];
$data = $_REQUEST['date_timestamp'];
$VAT_Doctor = $_REQUEST['VAT_Doctor'];
$VAT_client = $_REQUEST['VAT_client'];
echo("<p>$VAT_client</p>");
$sql = "INSERT INTO appointment (VAT_Doctor, date_timestamp, description, VAT_client) VALUES ($VAT_Doctor,$data,'$desc',$VAT_client)";
echo("<p>$sql</p>");
$result = $connection->exec($sql);
echo("<p>$result</p>");
 $connection = null;
?>
 </body>
</html>


