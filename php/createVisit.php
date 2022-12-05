<?php include 'database.php'; ?>
<?php

function visitDayLimit($securityLevel) {
    if ($securityLevel == 'low') return 7;
    elseif ($securityLevel == 'medium') return 30;
    else return 180;
}

$datePastVisit = NULL;
$dateFutureVisit = NULL;

$prisonerID = $_POST['prisoner_id'];
$visitorID = $_POST['visitor_id'];
$requestedDate = $_POST['visit_date'];
echo $requestedDate;

$lookupPastVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC LIMIT 1";
$pastVisitResult = $conn->query($lookupPastVisit);

if ($pastVisitResult->num_rows != 0) {
    $pastVisitResult = implode(" ", $pastVisitResult->fetch_assoc());
    $datePastVisit = date_create($pastVisitResult);
}

$lookupSecurity = "SELECT security_level FROM prisoner WHERE prisoner_id = $prisonerID ";
$securityLevel = $conn->query($lookupSecurity);
$securityLevel = $securityLevel->fetch_assoc();
$securityDateRangeDays = visitDayLimit($securityLevel["security_level"]);


$lookupFutureVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visit_date >= '$requestedDate' ORDER BY visit_date LIMIT 1";
$futureVisitResult = $conn->query($lookupFutureVisit);

if ($futureVisitResult->num_rows != 0) {
    $futureVisitResult = implode(" ", $futureVisitResult->fetch_assoc());
    $dateFutureVisit = date_create($futureVisitResult);
}

$requestedDateCopy = $requestedDate;
$requestedDate = date_create($requestedDate);

$insertQuery = "INSERT INTO visits (visit_date, visited, visitor_id, prisoner_id) VALUES ('$requestedDateCopy' , 0, $visitorID, $prisonerID)";

if ($datePastVisit && $dateFutureVisit) {
    $pastDateDiff = date_diff($datePastVisit, $requestedDate);
    $futureDateDiff = date_diff($requestedDate, $dateFutureVisit);
    
    if ($pastDateDiff->days >= $securityDateRangeDays && $futureDateDiff->days >= $securityDateRangeDays) {
        $insertResult = $conn->query($insertQuery);
        if ($insertResult) echo "Visit created successfully";
        else echo "Error inserting visit into database.";
    }
    else echo "Could not create visit - requested visit violates security restrictions."; 
}
elseif ($datePastVisit && !$dateFutureVisit) {
    $pastDateDiff = date_diff($datePastVisit, $requestedDate);

    if ($pastDateDiff->days >= $securityDateRangeDays) {
        $insertResult = $conn->query($insertQuery);
        if ($insertResult) echo "Visit created successfully";
        else echo "Error inserting visit into database.";
    } 
    else echo "Could not create visit - requested visit violates security restrictions.";     
} 
elseif (!$datePastVisit && $dateFutureVisit) {
    $futureDateDiff = date_diff($requestedDate, $dateFutureVisit);
    if ($futureDateDiff->days >= $securityDateRangeDays) { 
        $insertResult = $conn->query($insertQuery);
        if ($insertResult) echo "Visit created successfully";
        else echo "Error inserting visit into database.";
    }
    else echo "Could not create visit - requested visit violates security restrictions."; 

} 
else { 
    $insertResult = $conn->query($insertQuery);
    if ($insertResult) echo "Visit created successfully";
    else echo "Error inserting visit into database.";
}

if($insertResult){
    $echoQuery = "SELECT visit_id FROM visits WHERE prisoner_id = $prisonerID AND visit_date = '$requestedDateCopy'";
    $echoResult = $conn->query($echoQuery);

    $echoResult = $echoResult->fetch_assoc();
    $echoString = $echoResult["visit_id"];

    echo "<br/>Confirmation number for this visit is: " . $echoString."<br/>";
    
}

?>