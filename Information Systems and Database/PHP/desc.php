<html>
 <body>
 <h3>Description</h3>
 <form action="new_appointment.php" method="post">
 <p><input type="hidden" name="VAT_Doctor"
value="<?=$_GET['VAT_Doctor']?>"/></p>
 <p><input type="hidden" name="VAT_client"
value="<?=$_GET['VAT_client']?>"/></p>
 <p><input type="hidden" name="date_timestamp"
value="<?=$_GET['date_timestamp']?>"/></p>
 <p>Add a description: <input type="text" name="desc"/></p>
 <p><input type="submit" value="Submit"/></p>
 </form>
 </body>
</html>
