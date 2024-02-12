
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambola App</title>
  <link rel="stylesheet" href="styles.css">
<style> .container {
  text-align: center;
  margin-top: 50px;
 
}

.table-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
.box-color {
  background-color: rgb(255, 255, 255);
}
.ticket{
  display: flex;
      justify-content: center;
      align-items: center; 
      height: 20vh;
}
.box {
  border: 1px solid rgb(229, 203, 11);
  margin: 10px;
  padding: 10px;
}

table {
  border-collapse: collapse;
  margin: auto;
}

td {
  border: 1px solid black;
  width: 40px;
  height: 40px;
  text-align: center;
}</style>
</head>

<body>
  <div class="container">
    <h1>Tambola App</h1>

    <form action="index.php" method="post">
      <input type="submit" name="generate">
      <br>
      <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$value = array();
$arrays = [];
function generateTickets()
{

  require './dbconnect.php';

  $sql = "INSERT INTO tambola_id () VALUES ()";

  if ($conn->query($sql) === TRUE) {
    $last_insert_id = $conn->insert_id; 
    // echo "Last inserted main_id: " . $last_insert_id . "<br>";
    // echo "Ticket data inserted successfully<br>";

    for ($ticketIndex = 1; $ticketIndex <= 6; $ticketIndex++) {
      echo '<div class="ticket">';
      $ticket = array_fill(0, 3, array_fill(0, 9, 0));


      $columnRanges = array(
        array(1, 10),
        array(11, 20),
        array(21, 30),
        array(31, 40),
        array(41, 50),
        array(51, 60),
        array(61, 70),
        array(71, 80),
        array(81, 90)
      );
      $columnNumbers = array_fill(0, 9, array());

      for ($rowIndex = 0; $rowIndex < 3; $rowIndex++) {
        for ($colIndex = 0; $colIndex < 9; $colIndex++) {

          $range = $columnRanges[$colIndex];
          $number = rand($range[0], $range[1]);


          while (in_array($number, $columnNumbers[$colIndex])) {
            $number = rand($range[0], $range[1]);
          }


          $columnNumbers[$colIndex][] = $number;


          $ticket[$rowIndex][$colIndex] = $number;
        }
      }

      //  print_r($ticket); exit;
      echo '<table class="box table-bordered">';
      foreach ($ticket as $row) {
        echo '<tr>';

        foreach ($row as $cell) {

          if (isset($arrays[$cell])) {
            echo '<td>' . '0' . '</td>';
            $value[] = 0;
          } else {
            $arrays[$cell] = 1;
            echo '<td class="box-color">' . $cell . '</td>';
            $value[] = $cell;
          }
        }

        echo '</tr>';
      }


      echo '</table>';
      echo '</div>';



      if (!empty($value)) {

        require './dbconnect.php';

        $ticketJson = json_encode($value); // Convert ticket data to JSON format

        $sql = "INSERT INTO tambola_tickets (ticket_data, tambola_id) VALUES ('$ticketJson', $last_insert_id)";
        mysqli_error($conn);
        if ($conn->query($sql) === TRUE) {
          // echo "Ticket data inserted successfully<br>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
      $value = array();
    }
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_POST['generate'])) {
  generateTickets();
}

require './dbconnect.php';

$sql = "Select * from tambola_id where 1";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
  if ($row['id'] !== '1') {
    echo ' <a href="http://localhost/tambola/page.php?page=' . $row['id'] . '">' . $i . "</a>";
    $i++;
  }
}
?>

    </form>
  </div>
</body>

</html>
