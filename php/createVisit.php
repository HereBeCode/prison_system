<?php include 'database.php'; ?>
<?php 

    $prisonerID = $_POST['prisonerID'];
    $visitorID = $_POST['visitorID'];
    $requestedDate = $_POST['date'];

    $lookupPastVisit = "SELECT TOP 1 visit_date from visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC" ;
    

?>