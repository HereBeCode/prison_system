<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiz="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/style.css">
    <title> Create Visit Form </title>


    <?php include 'database.php'; ?>

</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="../index.html" class="logo">
                    <img src="img/prison-logo.png" alt="">
                    <span class="nav_item">ShawShank</span>
                </a>
            </li>
            <li>
                <a href="../index.html">
                    <i class="fas fa-list"></i>
                    <span class="nav_item">Main Menu</span>
                </a>
            </li>
            <li>
                <a href="../register_visitor.html">
                    <i class='fas fa-user'></i>
                    <span class="nav_item">Register A Visitor</span>
                </a>
            </li>
            <li>
                <a href="../create_visit.html">
                    <i class="fas fa-calendar-days"></i>
                    <span class="nav_item">Schedule A Visit</span>
                </a>
            </li>
            <li>
                <a href="../visit_checkin.html">
                    <i class="fas fa-pen-nib"></i>
                    <span class="nav_item">Visit Check-In</span>
                </a>
            </li>
            <li>
                <a href="../visitor_policy.html">
                    <i class="fas fa-clipboard"></i>
                    <span class="nav_item">Visit Policy</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="content">
        <?php 
            $selected_protocols = $_POST['protocol'];
            $num_selected_protocols = count($selected_protocols);

            if(!($num_selected_protocols == 6)) die("All protocols not met. Visit not allowed.");

            date_default_timezone_set('EST');
            $current_date = date("Y-m-d");
            $conf_number = $_POST['confirmationNumber'];

            $query = "SELECT * FROM visits WHERE visit_id = $conf_number";
            $result = $conn->query($query);

            if ($result->num_rows == 0) die("Cannot proceed with visit. No visit found for confirmation number: " . $conf_number);
        
            $result = $result->fetch_assoc();

            if ($result['visit_date'] == $current_date && $result['visited'] == 0) {
                $query = "UPDATE visits SET visited = 1 WHERE visit_id = $conf_number"; 
                $result = $conn->query($query);
                if (!$result) echo "Failed to update visited status for confirmation number: " . $conf_number . "<br />";

                echo "Visit check-in complete. Proceed with visit for confirmation number: " . $conf_number . "<br />";
                
            }
            else echo "Cannot complete visit. Incorrect date or visit already completed.<br />";

        
            $conn->close();

        ?>      
    </div>
</body>
</html>

