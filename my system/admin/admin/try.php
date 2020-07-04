<?php

$connect = mysqli_connect("localhost", "root", "", "testing");
$country = '';
$query = "SELECT country FROM country_state_city GROUP BY country ORDER BY country ASC";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($result))
{
 $country .= '<option value="'.$row["country"].'">'.$row["country"].'</option>';
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Fetch data after selecting from dropdown list</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:600px;">
   <h2 align="center">Fetch data after selecting from dropdown list</h2><br /><br />

   <select name="country" id="country" class="form-control action">
    <option value="">Select Country</option>
    <?php echo $country; ?>
   </select>

   <br />

   <h1 name="state" id="state" ></h1>

   <br />

  </div>
 </body>
</html>

<script>

$(document).ready(function(){
 $('.action').change(function(){
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "country")
   {
    result = 'state';
   }
   else
   {
    result = 'city';
   }
   $.ajax({
    url:"fetch.php",
    method:"POST",
    data:{action:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
   })
  }
 });
});
</script>