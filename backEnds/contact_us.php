<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
  

<?php
if (!isset($_SESSION)) session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  if (empty($email)) {
    $email = "demo@gmail.com";
  }
  $number = $_POST['Phone'];
  $subject = $_POST['subject'];
  $message = $_POST['conMsg'];

  $message_body = '
        Name: ' . $name . ',
        Phone Number: ' . $number . ',
        Email: ' . $email . ',
        Message: ' . $message;

  $to = "msifat5@gmail.com";


  if (mail($to, $subject, $message_body)) {
    ?>
    <script>
      swal({
        title: "Success!",
        text: "Thank you for contacting us!",
        icon: "success",
        button: "OK",
        closeOnClickOutside: false
      }).then(function() {
        window.location = "../index.php";
      });
    </script>

<?php
  }
}
?>
</body>
</html>