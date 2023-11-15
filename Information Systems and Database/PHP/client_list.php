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
$sql = "SELECT * FROM client";
$result = $connection->query($sql);
if ($result == FALSE)
{
$info = $connection->errorInfo();
echo("<p>Error: {$info[2]}</p>");
exit();
}
echo("<table border=\"1\">");
echo("<tr><td>name</td><td>VAT</td></tr>");
foreach($result as $row)
{
echo("<tr><td>");
echo($row['name']);
echo("</td><td>");
echo($row['VAT']);
echo("<td><a href=\"appointment_info.php?VAT=");
echo($row['VAT']);
echo("\">INFO</a></td>\n");
echo("</td></tr>");
}
echo("</table>");
$connection = null;
?>
</bo