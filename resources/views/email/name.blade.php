<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    body{margin:0px; padding:0px;}
    .wrapper{ max-width:600px; margin:0px; padding:0px; background:#f2f2f2;}
    .wrapper table{ width:100%; margin:0px; border:1px solid #DDD; border-collapse:collapse;}
    .wrapper table tr > td{ border:1px solid #DDD; padding:8px 10px; text-transform:uppercase;}
    </style>
</head>
<body>
   <div class="wrapper">
   <table>
   <tr> <td>Token No. : </td> <td> <?php echo $name['token']; ?> </td> </tr>
   <tr> <td>Department : </td> <td> <?php echo $name['department_name']; ?> </td> </tr>
   <?php if($name['doctor_name'] !== '') {?>
   <tr> <td>Doctor Name : </td> <td> <?php echo $name['doctor_name']; ?> </td> </tr>
   <tr> <td>Room No. : </td> <td> <?php echo $name['room_number']; ?> </td> </tr>
   <?php } ?>
   <tr> <td>Total Waiting : </td> <td> <?php echo $name['total']; ?> </td> </tr>   
   </table>
   </div> 
</body>
</html>

 
   
