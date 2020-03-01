<html>

<head>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>




  <?php

  $flag = 0;
  if (!isset($_SESSION)) session_start();

  require "dbConnection.php";


  if ($_POST['password'] == $_POST['rptPassword']) {
    $first_name = $mysqli->escape_string($_POST['first_name']);
    $last_name = $mysqli->escape_string($_POST['last_name']);

    if (preg_match("/^([A-Za-z]+)([.]*)(\s*)([A-Za-z\s]*)$/", $first_name) && preg_match("/^([A-Za-z]+)([.]*)(\s*)([A-Za-z\s]*)$/", $last_name)) {
      if (strlen($_POST['password']) > 5) {
        $area = $mysqli->escape_string($_POST['area']);
        $address = $mysqli->escape_string($_POST['address']);
        $category_id = $mysqli->escape_string($_POST['Category']);
        $phone = $_SESSION['phone'];


        $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));

        // Sub Category Section
        if (!empty($_POST['sub'])) {
          $sub_cat_search = $mysqli->query("SELECT sub_category_id FROM sub_category_table WHERE category_id = '$category_id'");
          $match_SC = array();
          while ($row = $sub_cat_search->fetch_assoc()) {
            $one_SC = $row['sub_category_id'];
            array_push($match_SC, $one_SC);
          }
          $fromForm = $_POST['sub'];
          $data = array_intersect($fromForm, $match_SC);
          $data = array_values(array_filter($data)); // RE Indexing


          // $data = $_POST['sub'];
          $serialized_array = serialize($data); // Convert To Store in DB
        } else {
          $data = array();
          $serialized_array = serialize($data); // Convert To Store in DB 
        }


        $result = $mysqli->query("SELECT * FROM worker_table WHERE phone_number='$phone'") or die($mysqli->error());
        $address_check = $mysqli->query("SELECT area_id FROM area_table WHERE area_name='$area'") or die($mysqli->error);

        if ($result->num_rows > 0) { } else {
          if ($address_check->num_rows > 0) {
            while ($row = $address_check->fetch_assoc()) {
              $area = $row['area_id'];
            }
          }
          #---Category id check
          //  $category_check=$mysqli->query("SELECT category_id FROM category where category_name='$category_name'") or die($mysqli->error);
          //  $category_id=$category_check->fetch_assoc()['category_id'];


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
                $file_destination = '../image/worker/' . $image_file_name;
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





                    #inserting in database 
                    if ($flag != 1) {

                      // $sub_category_id = array(); // store blank array value for sub_category_id
                      // $serialized_array = serialize($sub_category_id);

                      $sql = "INSERT INTO worker_table (image,category_id, sub_category_id, first_name, last_name, area, address, phone_number, password)"
                        . " VALUES ('$image_file_name','$category_id', '$serialized_array', '$first_name', '$last_name', '$area', '$address','$phone', '$password')";

                      if ($mysqli->query($sql) === TRUE) {
                        $_SESSION['first_name'] = $first_name;
                        $_SESSION['last_name'] = $last_name;
                        $_SESSION['phone'] = $phone;
                        $_SESSION['area'] = $area;
                        $_SESSION['logged_in'] = 1;
                        $_SESSION['image_name'] = $image_file_name;
                        $_SESSION['account_type'] = 'worker';

                        $worker_id_check = $mysqli->query("SELECT worker_id FROM worker_table WHERE phone_number = $phone");
                        $worker_id = $worker_id_check->fetch_assoc()['worker_id'];
                        $insert_avg_rating = $mysqli->query("INSERT INTO avg_worker_rating (worker_id) VALUES ('$worker_id')");
                        $insert_settings_time = $mysqli->query("INSERT INTO worker_settings_change_time (worker_id) VALUES ('$worker_id')");

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