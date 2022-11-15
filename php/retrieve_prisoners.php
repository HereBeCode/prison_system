<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'database.php'; ?>
    <?php 
        $sql = 'SELECT * FROM prisoner';
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["prisoner_id"] . " - Name: " . $row["first_name"] . " " . $row["last_name"]. "<br>";
            }
        }
        else echo "0 results";
        $conn->close();
    ?>
</body>
</html>