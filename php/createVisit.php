<?php include 'database.php'; ?>
<?php

function visitDayLimit($securityLevel)
{
    //assuming 30 day month
    if ($securityLevel == 'low') return 7;
    elseif ($securityLevel == 'medium') return 30;
    else return 180;
}

$datePastVisit = NULL;
$dateFutureVisit = NULL;

$prisonerID = $_POST['prisoner_id'];
$visitorID = $_POST['visitor_id'];
$requestedDate = $_POST['visit_date'];

$lookupPastVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC LIMIT 1";


$pastVisitResult = $conn->query($lookupPastVisit);

if ($pastVisitResult->num_rows != 0) {
    $pastVisitResult = implode(" ", $pastVisitResult->fetch_assoc());
    echo $pastVisitResult . "<br>";
    $datePastVisit = date_create($pastVisitResult);
} 
else echo "past visit is non existent <br>" ;


//echo $pastVisitResult . "<br>";

$lookupSecurity = "SELECT security_level FROM prisoner WHERE prisoner_id = $prisonerID ";

$lookupFutureVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visit_date >= '$requestedDate' ORDER BY visit_date LIMIT 1";

$futureVisitResult = $conn->query($lookupFutureVisit);

if ($futureVisitResult->num_rows != 0) {
    $futureVisitResult = implode(" ", $futureVisitResult->fetch_assoc());
    echo $futureVisitResult . "<br>";
    $dateFutureVisit = date_create($futureVisitResult);
} 
else echo "future visit is nonexistent";


echo gettype($futureVisitResult) . "<br> <br>";



$requestedDate = date_create($requestedDate);
echo "req date = " . $requestedDate->format('Y-m-d') . "<br>";

//4 cases, past visit and future visit exist, 1 of each only, none
//if date_create fails it returns "false" according to docs
if ($datePastVisit && $dateFutureVisit) {
    $pastDateDiff = date_diff($datePastVisit, $requestedDate);
    $futureDateDiff = date_diff($requestedDate, $dateFutureVisit);
} 
elseif ($datePastVisit && !$dateFutureVisit) {
    echo "Future visit null case satisfied";
} 
elseif (!$datePastVisit && $dateFutureVisit) {
    echo "Past visit null case satisfied";
} 
else {
    echo "else triggered";
}



//echo $pastDateDiff->d;


//echo $futureDateDiff->d;


?>