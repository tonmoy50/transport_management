<?php

		$host="localhost";
		$username="root";
		$password="";
		$database="transport_system";

		function parseToXML($htmlStr)
		{
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
		}

		// Opens a connection to a MySQL server
		$connection=mysqli_connect ('localhost', $username, $password);
		if (!$connection) {
		  die('Not connected : ' . mysqli_error());
		}

		// Set the active MySQL database
		$db_selected = mysqli_select_db($connection, $database);
		if (!$db_selected) {
		  die ('Can\'t use db : ' . mysqli_error());
		}

		// Select all the rows in the markers table
		$query = "SELECT * FROM bus WHERE 1";
		$result = mysqli_query($connection, $query);
		if (!$result) {
		  die('Invalid query: ' . mysqli_error($connection));
		}

		header("Content-type: text/xml");

		// Start XML file, echo parent node
		echo "<?xml version='1.0' ?>";
		echo '<markers>';
		$ind=0;
		// Iterate through the rows, printing XML nodes for each
		while ($row = mysqli_fetch_assoc($result)){
		  // Add to XML document node
		  echo '<marker ';
		  echo 'Registration="' . $row['Registration_no'] . '" ';
		  echo 'Route="' . parseToXML($row['Route_no']) . '" ';
		  echo 'Owner="' . parseToXML($row['Owner_ID']) . '" ';
		  echo 'Company="' . $row['Company_ID'] . '" ';
		  echo 'Latitude="' . $row['Latitude'] . '" ';
		  echo 'Longitude="' . $row['Longitude'] . '" ';
		  echo '/>';
		  $ind = $ind + 1;
		}

		// End XML file
		echo '</markers>';

?>
