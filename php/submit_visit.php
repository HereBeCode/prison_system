<?php include 'database.php'; ?>
<?php 
    $selected_protocols = $_POST['protocol'];
    $num_selected_protocols = count($selected_protocols);

    if(!($num_selected_protocols == 6)) die("All protocols not met.");

    $conf_number = $_POST['confirmationNumber'];
    $query = "UPDATE visits SET visited = 1 WHERE visit_id = $conf_number";
    $result = $conn->query($sql);
   
    $message = "";
    if (!$result) echo "Error in updating visit: $conf_number ";
    else echo "Visit: $conf_number completed successfully.";
?>