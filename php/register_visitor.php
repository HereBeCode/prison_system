<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title> 

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

            //JS validation
            //first name Upper case start, all lower case following, can only have[-] special character
            //last name can have a mix of upper/lower case, can also have special characters [-']

            $fn = $_POST['firstName'];
            $ln = $_POST['lastName'];

            $query = "INSERT INTO visitor (first_name, last_name) VALUES ('$fn', '$ln')";

            $result = $conn->query($query);

            if(!$result) echo "Error inserting into DB.";
            else echo "Visitor successfully added!";

            //Free db connection
            $conn->close();

        ?>
    </div>
  </body>
</html>