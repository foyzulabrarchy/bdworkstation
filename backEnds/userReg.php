<html>

<head>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

  <?php
  $flag = 0;

  if (!isset($_SESSION)) session_start();

  require "dbConnection.php";

  $button = $_POST['userSubmit'];

  if ($_POST['password'] == $_POST['rptPassword']) {
    $first_name = $mysqli->escape_string($_POST['first_name']);
    $last_name = $mysqli->escape_string($_POST['last_name']);
    if (preg_match("/^([A-Za-z]+)([.]*)(\s*)([A-Za-z\s]*)$/", $first_name) && preg_match("/^([A-Za-z]+)([.]*)(\s*)([A-Za-z\s]*)$/", $last_name)) {
      if (strlen($_POST['password']) > 5) {
        $address = $mysqli->escape_string($_POST['address']);
        $area = $mysqli->escape_string($_POST['area']);
        $phone = $_SESSION['phone'];


        $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));

        $result = $mysqli->query("SELECT * FROM user_table WHERE phone_number='$phone'") or die($mysqli->error());
        $address_check = $mysqli->query("SELECT area_id FROM area_table WHERE area_name='$area'") or die($mysqli->error);

        if ($result->num_rows > 0) { } else {
          if ($address_check->num_rows > 0) {
            while ($row = $address_check->fetch_assoc()) {
              # code...
              $area = $row['area_id'];
            }
          }
          # image hangler--------
          $image_name = $_FILES['image_name']['name'];
          $image_tmp_name = $_FILES['image_name']['tmp_name'];
          $image_size = $_FILES['image_name']['size'];
          $image_error = $_FILES['image_name']['error'];
          $image_type = $_FILES['image_name']['type'];


          $image_file_ext = explode('.', $image_name);
          $image_actual_ext = strtolower(end($image_file_ext));

          $allowed = array('jpg', 'jpeg', 'png');

          if (in_array($image_actual_ext, $allowed)) {
            # code...
            if ($image_error === 0) {
              if ($image_size < 5000000) {
                $image_file_name = uniqid('', true) . "." . $image_actual_ext;
                $file_destination = '../image/user/' . $image_file_name;
                if (move_uploaded_file($image_tmp_name, $file_destination)) { }
              } else {
                $flag = 1;
                ?>
                <script>
                  swal({
                    title: "Error!",
                    text: "File should be less than or equal 4mb!",
                    icon: "error",
                    button: "OK",
                    closeOnClickOutside: false
                  }).then(function() {
                    window.location = "../completeProfile.php";
                  });
                </script>
              <?php
                          }
                        } else {
                          $flag = 1;
                          ?>
              <script>
                swal({
                  title: "Error!",
                  text: "Error uploading a file!",
                  icon: "error",
                  button: "OK",
                  closeOnClickOutside: false
                }).then(function() {
                  window.location = "../completeProfile.php";
                });
              </script>
            <?php
                      }
                    } else {
                      $flag = 1;
                      ?>
            <script>
              swal({
                title: "Error!",
                text: "Wrong image type!",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false
              }).then(function() {
                window.location = "../completeProfile.php";
              });
            </script>
            <?php
                    }





                    if ($flag != 1) {
                      #inserting in database
                      $sql = "INSERT INTO user_table (image, phone_number, first_name, last_name, area, address, password)"
                        . " VALUES ('$image_file_name','$phone', '$first_name', '$last_name', '$area', '$address', '$password')";

                      if ($mysqli->query($sql) === TRUE) {
                        $_SESSION['first_name'] = $first_name;
                        $_SESSION['last_name'] = $last_name;
                        $_SESSION['phone'] = $phone;
                        $_SESSION['area'] = $area;
                        $_SESSION['image_name'] = $image_file_name;
                        $_SESSION['logged_in'] = 1;
                        $_SESSION['account_type'] = 'user';

                        header("Refresh:0; url=../profile.php");
                      } else {
                        ?>
              <script>
                swal({
                  title: "Error!",
                  text: "Something is wrong!",
                  icon: "error",
                  button: "OK",
                  closeOnClickOutside: false
                }).then(function() {
                  window.location = "../completeProfile.php";
                });
              </script>

        <?php
                  }
                }
              }
            } else {
              ?>
        <script>
          swal({
            title: "Error!",
            text: "Your Password must be 6 character!",
            icon: "error",
            button: "OK",
            closeOnClickOutside: false
          }).then(function() {
            window.location = "../completeProfile.php";
          });
        </script>

      <?php
          }
        } else {
          ?>
      <script>
        swal({
          title: "Error!",
          text: "Your Name is not correct!",
          icon: "error",
          button: "OK",
          closeOnClickOutside: false
        }).then(function() {
          window.location = "../completeProfile.php";
        });
      </script>

    <?php

      }
    } else {
      ?>
    <script>
      swal({
        title: "Error!",
        text: "Password do not match!",
        icon: "error",
        button: "OK",
        closeOnClickOutside: false
      }).then(function() {
        window.location = "../completeProfile.php";
      });
    </script>

  <?php
  }




  ?>
</body>

</html>