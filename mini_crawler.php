<?php
  $original_file = file_get_contents("http://www.dmegs.com/latest_sites/");
  $stripped_file = strip_tags($original_file, "<a>");
  preg_match_all("/<a(?:[^>]*)href=\"(http[^\"]*)\"(?:[^>]*)>(?:[^<]*)<\/a>/is", $stripped_file, $matches);

  set_time_limit(0);
  
  echo "<table border='1px'>";
  $file = fopen("results.csv", "w");

  // print the header lines to the CSV file
  $header = array("URL", "Is it Drupal?", "Detection Method");
  fputcsv($file, $header);
  
  foreach($matches[1] as &$value) {

	// if $value is equal to $prevValue it is a duplicate, so skip it
	if($prevValue == $value) {
		continue;
	}
	
	// give prevValue the current value so it will the previous on next iteration
	$prevValue = $value;
	
	//print out the name of the website and the Drupal header
	echo "<tr><td>Website</td><td>";
	print_r($value);
	echo "</td></tr>";
	echo "<tr><td>Is it Drupal?</td>";
	
	// get the http headers for the url at value
	$headers = get_headers($value);
	
	// set headers to false so the loop continues if it is not found
	$hasHeader = false;
	
	// go through the headers and look for the "Expires" header
	// if it is found, print yes and stop the loop
	foreach($headers as &$http) {
		if($http == "Expires: Sun, 19 Nov 1978 05:00:00 GMT") {
			echo "<td>Yes</td>";
			echo "<td>Detected by HTTP header</td>";
			echo "</tr>";
			$output = array($value, "Drupal", "Detected by the HTTP Headers");
			fputcsv($file, $output);
			$hasHeader = true;
			break;
		}
	}
	
	// if the header is found, continue to the next URL
	if($hasHeader) {
		continue;
	}

	// if the checks don't work, output that the site is not Drupal
	
	echo "<td>No</td>";
	echo "<td>N/A</td>";
	$output = array($value);
	fputcsv($file, $output);
	
	echo "</tr>";
}

echo "</table>";

// make sure we print out all our content by using the flush function
// this executes after the 5 minutes is over
flush();
fclose($file);

echo "<h1>Check the results.csv file in this directory for the results of the script!</h1>";

  
?>