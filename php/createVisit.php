<?php include 'database.php'; ?>
<?php 

    $prisonerID = $_POST['prisonerID'];
    $visitorID = $_POST['visitorID'];
    $requestedDate = $_POST['date'];

    $lookupPastVisit = "SELECT visit_date from visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC LIMIT 1" ;
    
    $lookup

?>