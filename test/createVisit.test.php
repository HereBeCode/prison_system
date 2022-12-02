<?php include 'database.php'; ?>
<?php

function visitDayLimit($securityLevel)
{
    //assuming 30 day month
    if ($securityLevel == 'low') {
        return 7;

    } elseif ($securityLevel == 'medium') {
        return 30;

    } else {
        return 180;

    }

}



$datePastVisit = NULL;
$dateFutureVisit = NULL;

// High Security Prisoner - 26
// Just past fail 
$prisonerID = 26;
$visitorID = 5;
$requestedDate = "2022-11-18";

// Just pass pass
$prisonerID = 26;
$visitorID = 5;
$requestedDate = "2024-10-31";

// BFP left fail
$prisonerID = 26;
$visitorID = 5;
$requestedDate = "2022-11-30";

// BFP right fail
$prisonerID = 26;
$visitorID = 5;
$requestedDate = "2024-10-30";

// BFP pass
$prisonerID = 26;
$visitorID = 5;
$requestedDate = "2023-07-31";

// High Security Prisoner - 27
// Just future fail
$prisonerID = 27;
$visitorID = 5;
$requestedDate = "2024-12-25";

// Just future pass
$prisonerID = 27;
$visitorID = 5;
$requestedDate = "2023-06-01";




// Medium Security Prisoner - 28
// Just past fail 
$prisonerID = 28;
$visitorID = 5;
$requestedDate = "2022-11-18";

// Just pass pass
$prisonerID = 28;
$visitorID = 5;
$requestedDate = "2024-10-31";

// BFP left fail
$prisonerID = 28;
$visitorID = 5;
$requestedDate = "2022-11-18";

// BFP right fail
$prisonerID = 28;
$visitorID = 5;
$requestedDate = "2024-10-30";

// BFP pass
$prisonerID = 28;
$visitorID = 5;
$requestedDate = "2023-07-31";

// Medium Security Prisoner - 29
// Just future fail
$prisonerID = 29;
$visitorID = 5;
$requestedDate = "2024-12-25";

// Just future pass
$prisonerID = 29;
$visitorID = 5;
$requestedDate = "2023-06-01";






// Low Security Prisoner - 36
// Just past fail 
$prisonerID = 36;
$visitorID = 5;
$requestedDate = "2022-11-18";

// Just past pass
$prisonerID = 36;
$visitorID = 5;
$requestedDate = "2023-03-15";

// BFP left fail
$prisonerID = 36;
$visitorID = 5;
$requestedDate = "2022-11-18";

// BFP right fail
$prisonerID = 36;
$visitorID = 5;
$requestedDate = "2023-03-14";

// BFP pass
$prisonerID = 36;
$visitorID = 5;
$requestedDate = "2022-12-15";

// Low Security Prisoner - 37
// Just future fail
$prisonerID = 37;
$visitorID = 5;
$requestedDate = "2024-12-31";

// Just future pass
$prisonerID = 37;
$visitorID = 5;
$requestedDate = "2023-06-01";


function testfunction($conn, $prisonerID, $visitorID, $requestedDate) {

$lookupPastVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visited = 1 ORDER BY visit_date DESC LIMIT 1";


$pastVisitResult = $conn->query($lookupPastVisit);

if ($pastVisitResult->num_rows != 0) {
    $pastVisitResult = implode(" ", $pastVisitResult->fetch_assoc());
    echo $pastVisitResult . "<br>";
    $datePastVisit = date_create($pastVisitResult);
} else {
    echo "past visit is non existent <br>" ;

}



//echo $pastVisitResult . "<br>";

$lookupSecurity = "SELECT security_level FROM prisoner WHERE prisoner_id = $prisonerID ";
$securityLevel = $conn->query($lookupSecurity);
$securityDateRangeDays = visitDayLimit($securityLevel);
echo " ".$securityDateRangeDays." secdateranedays";


$lookupFutureVisit = "SELECT visit_date FROM visits WHERE prisoner_id = $prisonerID AND visit_date >= '$requestedDate' ORDER BY visit_date LIMIT 1";
$futureVisitResult = $conn->query($lookupFutureVisit);

if ($futureVisitResult->num_rows != 0) {
    $futureVisitResult = implode(" ", $futureVisitResult->fetch_assoc());
    echo $futureVisitResult . "<br>";
    $dateFutureVisit = date_create($futureVisitResult);


} else {
    echo "future visit is nonexistent";
    
}


echo gettype($futureVisitResult) . "<br> <br>";



$requestedDate = date_create($requestedDate);
echo "req date = " . $requestedDate->format('Y-m-d') . "<br>";

$requestedDateString = $requestedDate->format('Y-m-d');
echo "fucking strng $requestedDateString";
$insertQuery = "INSERT INTO visits (visit_date, visited, visitor_id, prisoner_id) VALUES ($requestedDateString , 0, $visitorID, $prisonerID)";

//4 cases, past visit and future visit exist, 1 of each only, none
//if date_create fails it returns "false" according to docs
if ($datePastVisit && $dateFutureVisit) {
    echo "pastvisit date = " . $datePastVisit->format('Y-m-d') . "<br>";
    echo "future date = " . $dateFutureVisit->format('Y-m-d') . "<br>";


    $pastDateDiff = date_diff($datePastVisit, $requestedDate);
    $futureDateDiff = date_diff($requestedDate, $dateFutureVisit);
    if ($pastDateDiff->days >= $securityDateRangeDays && $futureDateDiff->days >= $securityDateRangeDays) {
        $insertResult = $conn->query($insertQuery);

    } else {
        echo "Error creating visit invalid date";
    }
    //how deep do we want to go in error messages here?



} elseif ($datePastVisit && !$dateFutureVisit) {
    echo "Future visit null case satisfied";
    $pastDateDiff = date_diff($datePastVisit, $requestedDate);

    if ($pastDateDiff->days >= $securityDateRangeDays) {
        echo "<br> hit if block in future null";
        $insertResult = $conn->query($insertQuery);

    } else {
        echo "Error inserting visit, prisoner has had visit $pastDateDiff->days days prior.";
    }


} elseif (!$datePastVisit && $dateFutureVisit) {
    echo "Past visit null case satisfied";
    $futureDateDiff = date_diff($requestedDate, $dateFutureVisit);
    if ($futureDateDiff->days >= $securityDateRangeDays) {
        $insertResult = $conn->query($insertQuery);

    } else {
        echo "Error inserting visit, prisoner has had visit $futureDateDiff->days days prior.";
    }

} else {
    echo "else triggered - unexpected error";

}
}


//echo $pastDateDiff->days;


//echo $futureDateDiff->days;


?>