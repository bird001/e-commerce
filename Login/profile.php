<?php
include("../Login/session.php");
include("../DB/MySQLI.php");

$custid=$_SESSION['custid'];

$sql = "SELECT CustomerId,FirstName,LastName,Dob,Points FROM new_mega_mart.Customer
where customerId= '$custid'";		
$query = mysqli_query($connmysqli, $sql);


$sql_contact_details = "Call sp_GetContactDetails ('$custid')";		
$query_contact_details = mysqli_query($connmysqli, $sql_contact_details);

if (!$query_contact_details) {
	die ('SQL Error: ' . mysqli_error($connmysqli));
}

$sql_cust_addr = "Call sp_GetCustomerAddress ('$custid')";		
$query_cust_addr = mysqli_query($connmysqli, $sql_cust_addr);

/*
if (!$query_cust_addr) {
	die ('SQL Error: ' . mysqli_error($connmysqli));
}
 * 
 */
?>
<html>
<head>
	<title>Profile Page</title>
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
	<h1>Customer Details</h1>
	<table class="data-table"> 
		<thead>
			<tr>
				<th>Customer Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>DOB</th>
				<th>Points</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		while ($row = mysqli_fetch_array($query))
		{ 
			echo '<tr>
					<td>'.$row['CustomerId'].'</td>
					<td>'.$row['FirstName'].'</td>
					<td>'.$row['LastName'].'</td>
					<td>'. date('F d, Y', strtotime($row['dob'])) . '</td>
					<td>'.$row['Points'].'</td>
				</tr>';
		  
		}?>
		</tbody>
		<tfoot>
		 
		</tfoot>
	</table>
	<br/>
	<br/>
	<h1>Contact Details</h1>
	<table class="data-table"> 
		<thead>
			<tr>
				<th>Contact Type</th>
				<th>Contact Detail</th>
				 
			</tr>
		</thead>
		<tbody>
		<?php 
		while ($row = mysqli_fetch_array($query_contact_details))
		{ 
			echo '<tr>
					<td>'.$row['ContactType'].'</td>
					<td>'.$row['ContactDetail'].'</td> 
				</tr>';
		  
		}?>
		</tbody>
		<tfoot>
		 
		</tfoot>
	</table>
	<br/>
	<br/>
	<h1>Customer Address</h1>
	<table class="data-table"> 
		<thead>
			<tr>
				<th>Address 1</th>
				<th>Address 2</th>
				<th>Parish</th>
				<th>Billing Address Indicator</th>
				 <th>Shipping Address Indicator</th>
				  
			</tr>
		</thead>
		<tbody>
		<?php 
		while ($row = mysqli_fetch_array($query_cust_addr))
		{ 
			echo '<tr>
					<td>'.$row['Address1'].'</td>
					<td>'.$row['Address2'].'</td> 
					<td>'.$row['Parish'].'</td> 
					<td>'.$row['Billing Address Indicator'].'</td> 
					<td>'.$row['Shipping Address Indicator'].'</td> 
				</tr>';
		  
		}?>
		</tbody>
		<tfoot>
		 
		</tfoot>
	</table>
</body>
</html>
 
 
   
