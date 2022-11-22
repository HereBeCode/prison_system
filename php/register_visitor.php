<?php include 'database.php'; ?>
<?php 

    //JS validation
    //first name Upper case start, all lower case following, can only have[-] special character
    //last name can have a mix of upper/lower case, can also have special characters [-']
    
    $fn = $_POST['firstName'];
    $ln = $_POST['lastName'];
    
    $query = "INSERT INTO visitor (first_name, last_name) VALUES ('$fn', '$ln')";
    
    $result = $conn->query($query);

    if(!$result) echo "Error inserting into DB.";
    else echo "Visitor successfully updated!";

    //Free db connection
    $conn->close();
    
?>