<?php
require './dbconnect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_GET['page']) {
    $page_no = $_GET['page'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM tambola_id WHERE id = $page_no";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $num = mysqli_num_rows($result);
    $data = array(); 
    while ($row = mysqli_fetch_assoc($result)) {
        $sql1 = 'SELECT id, ticket_data FROM tambola_tickets WHERE tambola_id =' . $row['id'];
        $result1 = mysqli_query($conn, $sql1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $ticketData = json_decode($row1['ticket_data'], true);
            $chunks = array_chunk($ticketData, 9);
            $data[$row1['id']] = $chunks;
        }
    }


    $finalData = array("tickets" => $data);
    $finalJsonString = json_encode($finalData);

    echo $finalJsonString;

    mysqli_free_result($result);
} else {
    echo "No page parameter provided.";
}

mysqli_close($conn);
