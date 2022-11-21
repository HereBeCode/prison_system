<?php include 'database.php'; ?>
<?php 
    $selected_protocols = $_POST['protocol'];
    $num_selected_protocols = count($selected_protocols);

    if(!($num_selected_protocols == 6)) die("All protocols not met.");

    $conf_number = $_POST['confirmationNumber'];

    // Add logic for checking if visit date == current date ---> if not current date decline visit 
    // Add logic for checking if patient has already been visited ---> if visited == 1, refuse visit.
    // Any other stuff to check?
    // Likely requires a SELECT query to grab the row with the visit_id == confirmationNumber, check for the logic above and reject the visit (i.e. do not execute the next two lines of code)

    if(!$conf_number==1) echo "Error";
    $query = "UPDATE visits SET visited = 1 WHERE visit_id = $conf_number";
    $result = $conn->query($query);
   
    $message = "";
    if (!$result) echo "Error in updating visit: $conf_number ";
    else echo "Visit: $conf_number completed successfully.";
?>