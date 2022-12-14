        <?php 
        include_once 'index.php';
         ?>



<?php 
 
// Load the database configuration file 
include_once 'index.php'; 
 
// Fetch records from database 
$query = $db->query("SELECT * FROM t0"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "JobseekersT0_" . date("F j, Y, g:i a") . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Timestamp','Date','BnFCode','Name', 'PhoneNumber', 'Email', 'Gender', 'Education', 'WorkStatus', 'MigrationStatus', 'Governorate'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['Timestamp'],$row['Date'],$row['BnFCode'],$row['Name'], $row['PhoneNumber'], $row['Email'], $row['Gender'], $row['Education'], $row['WorkStatus'], $row['MigrationStatus'], $row['Governorate']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>