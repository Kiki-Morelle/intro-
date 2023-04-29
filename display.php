<?php
include "conn.php";
$retrieve = mysqli_query($con, "SELECT * FROM user ORDER BY id");
?>
<?php 
$num = 1;
$i=0; 
  if (mysqli_num_rows($retrieve) > 0) {
  
  ?>   
<!DOCTYPE html>
<html>
   <head>
      <title>Subscribers</title>
      <link rel="stylesheet" type="text/css" href="ma.css">
      <meta charset="UTF-8">
      <meta name="view-port" content="width=device-width, initial-scale=2"> 
   </head>
   <body class="bg-dark">
  <table class="customers" class="mt-3">
      <thead class=" bg-success">
         <tr>
            <th>SN</th>
            <th>Emails</th>
            <th>Action</th>
         </tr>
      </thead>
      <?php 
         $num = 1;
         $i=0;
         while ($result = mysqli_fetch_assoc($retrieve)) {
         ?>

      <tbody class="table-bordered">
         <tr>
            <td><?php echo $num++; ?></td>
            <td><?php echo $result["email"]; ?></td>
            <td>
               <a href="delete.php?email=<?php echo $result["email"]; ?>"
               type="submit"></i> &#10006;</a><br>
            </td>
         </tr>
      </tbody>
      <?php 
         $i++;
         }
         ?>
   </table>
   </div>
   <?php 
  }else {
     echo 'No result found';
  } ?>

   </body>
  </html>