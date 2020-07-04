<?php
//fetch.php
if(isset($_POST["action"])){
    $connect = mysqli_connect("localhost", "root", "", "testing");
    $output = '';

    if($_POST["action"] == "country"){
        $query = "SELECT state FROM country_state_city WHERE country = '".$_POST["query"]."' GROUP BY state";
        $result = mysqli_query($connect, $query);

        while($row = mysqli_fetch_array($result)) {
              $output .= '<h1>'.$row["state"].'</h1>';
        }
    }

    echo $output;
  }
?>