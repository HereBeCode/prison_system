<?php include '../../php/database.php'; ?>
<?php
    $drop_all = "DELETE FROM visits";
    $drop_all_result = $conn->query($drop_all);
    if($drop_all_result) echo "Successfully dropped all rows in visits table <br>";

    $repopulate = "INSERT INTO visits VALUES
    (1, '2022-11-17', 1, 2, 26),
    (3, '2022-05-15', 1, 2, 26),
    (7, '2022-10-02', 1, 4, 28),
    (8, '2022-11-02', 1, 4, 28),
    (10, '2022-10-07', 1, 5, 36),
    (11, '2022-10-15', 1, 5, 36),
    (12, '2022-11-16', 1, 5, 36),
    (26, '2025-01-01', 0, 2, 27),
    (27, '2025-01-01', 0, 2, 29),
    (28, '2025-01-01', 0, 2, 37)";
    $repopulate_result = $conn->query($repopulate);
    if($repopulate_result) echo "Successfully repopulated table";

    $conn->close();

?>
