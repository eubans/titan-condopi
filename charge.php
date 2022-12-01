<?php
$con = mysqli_connect("localhost","tg4ever_mosa","mosa@123","tg4ever_rental");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT c.selling_date, c.amount, ct.charge_type,bb.tax FROM charge c 
				INNER JOIN charge_type ct ON ct.charge_type_id=c.charge_type_id AND ct.is_deleted=0
				INNER JOIN (select sum(`percentage`) as tax,  cttl.charge_type_id from  `tax_type` tt 
inner join charge_type_tax_list cttl on cttl.tax_type_id=tt.tax_type_id 
where tt.is_deleted=0
group by cttl.charge_type_id) AS bb ON bb.charge_type_id=ct.charge_type_id
		WHERE c.is_deleted=0
				"; 
$result = mysqli_query($con,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Results</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Results</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Selling Date</th>
        <th>Charge Type</th>
        <th>Amount</th>
    	<th>Tax</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_array($result)) : ?>
      <tr>
        <td><?php echo $row["selling_date"]; ?></td>
        <td><?php echo ucwords($row["charge_type"]); ?></td>
    	<td><?php echo $row["amount"]; ?></td>
    	<td><?php echo number_format($row["tax"]*$row["amount"],2); ?></td>
      </tr>
       <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php
	// Free result set
	mysqli_free_result($result);
	mysqli_close($con);
?>