<?php include 'database.php'; ?>
<?php 

    $prisonerID = $_POST['prisonerID'];
    $visitorID = $_POST['visitorID'];
    $requestedDate = $_POST['date'];

    $lookupPastVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC LIMIT 1" ;
    
    $lookupSecurity = "SELECT security_level FROM prisoner WHERE prisoner_id = $prisonerID " ;

    $lookupFutureVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID WHERE visit_date >= $requestedDate ORDER BY visit_date LIMIT 1";

?>