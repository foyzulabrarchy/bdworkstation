<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>


    <?php
    if (!isset($_SESSION)) session_start();
    require "dbConnection.php";
    require 'vendor/autoload.php';

    use Carbon\Carbon;

    if ($_SESSION['logged_in'] != 1) {
        #when not loggedin
        header("Location: ../index.php?not_logged_in");
    } else {
        $account_type = $_SESSION['account_type'];

        if ($account_type == 'user') {
            $user_id = $_SESSION['user_id'];
            $user_query = $mysqli->query("SELECT * FROM user_table WHERE user_id = '$user_id'");
        }
        if ($account_type == 'worker') {
            $worker_id = $_SESSION['worker_id'];
            $worker_query = $mysqli->query("SELECT * FROM worker_table WHERE worker_id = '$worker_id'");
            $worker_setting_change_query = $mysqli->query("SELECT number_of_changes FROM worker_settings_change_time WHERE worker_id = '$worker_id'");
            if ($worker_setting_change_query->num_rows > 0) {
                $worker_setting_change_query_fetch = $worker_setting_change_query->fetch_assoc()['number_of_changes'];
            } else {
                $worker_setting_change_query_fetch = 0;
            }
        }
        #when logged in
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_GET['pi'])) {
                $address = $_POST['update_address'];
                $area = $_POST['area'];
                if ($account_type == 'user') {

                    $sql = "UPDATE user_table SET address = '$address' , area = '$area' WHERE user_id = '$user_id'";

                    if ($mysqli->query($sql) === TRUE) {
                        $_SESSION['area'] = $area;
                        ?><script>
                            swal({
                                title: "Done!",
                                text: "Your info(s) are Updated!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script> <?php
                                                    }
                                                } elseif ($account_type == 'worker') {

                                                    $sql = "UPDATE worker_table SET address = '$address' , area = '$area' WHERE worker_id = '$worker_id'";

                                                    if ($mysqli->query($sql) === TRUE) {
                                                        $_SESSION['area'] = $area;

                                                        ?><script>
                            swal({
                                title: "Done!",
                                text: "Your info(s) are Updated!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script> <?php
                                                    }
                                                }
                                            }

                                            if (isset($_GET['pwd'])) {
                                                if ($account_type == 'user') {
                                                    $old_pwd = $user_query->fetch_assoc()['password'];
                                                    if (password_verify($_POST['oldPwd'], $old_pwd)) {
                                                        if ($_POST['pwdForm'] == $_POST['ConPwdForm']) {
                                                            $pwd = $mysqli->escape_string(password_hash($_POST['pwdForm'], PASSWORD_BCRYPT));
                                                            $sql = "UPDATE user_table SET password = '$pwd' WHERE user_id = '$user_id'";

                                                            if ($mysqli->query($sql) === TRUE) {
                                                                ?><script>
                                    swal({
                                        title: "Done!",
                                        text: "Your Password is Updated!",
                                        icon: "success",
                                        button: "OK",
                                        closeOnClickOutside: false
                                    }).then(function() {
                                        window.location = "../setting.php";
                                    });
                                </script> <?php
                                                                    }
                                                                } else {

                                                                    ?><script>
                                swal({
                                    title: "Error!",
                                    text: "Your New Password do not match!",
                                    icon: "error",
                                    button: "OK",
                                    closeOnClickOutside: false
                                }).then(function() {
                                    window.location = "../setting.php";
                                });
                            </script> <?php
                                                            }
                                                        } else {
                                                            ?><script>
                            swal({
                                title: "Error!",
                                text: "Your Old Password do not match!",
                                icon: "error",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script> <?php
                                                    }
                                                }
                                                //For Worker Password
                                                if ($account_type == 'worker') {
                                                    $old_pwd = $worker_query->fetch_assoc()['password'];
                                                    if (password_verify($_POST['oldPwd'], $old_pwd)) {
                                                        if ($_POST['pwdForm'] == $_POST['ConPwdForm']) {
                                                            $pwd = $mysqli->escape_string(password_hash($_POST['pwdForm'], PASSWORD_BCRYPT));
                                                            $sql = "UPDATE worker_table SET password = '$pwd' WHERE worker_id = '$worker_id'";

                                                            if ($mysqli->query($sql) === TRUE) {
                                                                ?><script>
                                    swal({
                                        title: "Done!",
                                        text: "Your Password is Updated!",
                                        icon: "success",
                                        button: "OK",
                                        closeOnClickOutside: false
                                    }).then(function() {
                                        window.location = "../setting.php";
                                    });
                                </script> <?php
                                                                    }
                                                                } else {
                                                                    ?><script>
                                swal({
                                    title: "Error!",
                                    text: "Your New Password do not match!",
                                    icon: "error",
                                    button: "OK",
                                    closeOnClickOutside: false
                                }).then(function() {
                                    window.location = "../setting.php";
                                });
                            </script> <?php
                                                            }
                                                        } else {
                                                            ?><script>
                            swal({
                                title: "Error!",
                                text: "Your Old Password do not match!",
                                icon: "error",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script> <?php
                                                    }
                                                }
                                            }
                                        }

                                        if (isset($_GET['deactive'])) {
                                            if ($account_type == 'user') { // 1 means Deactivated
                                                $sql = "UPDATE user_table SET is_activated = '1' WHERE user_id = '$user_id'";

                                                if ($mysqli->query($sql) === TRUE) {
                                                    ?>
                    <script>
                        swal({
                            title: "Warning!",
                            text: "Your Account is Deactivated!",
                            icon: "warning",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../index.php?logout=1";
                        });
                    </script>
                <?php
                            }
                        }

                        if ($account_type == 'worker') { // 1 means Deactivated
                            $sql = "UPDATE worker_table SET is_activated = '1' WHERE worker_id = '$worker_id'";

                            if ($mysqli->query($sql) === TRUE) {
                                ?>
                    <script>
                        swal({
                            title: "Warning!",
                            text: "Your Account is Deactivated!",
                            icon: "warning",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../index.php?logout=1";
                        });
                    </script>
                <?php
                            }
                        }
                    }

                    if (isset($_GET['delete'])) {
                        if ($account_type == 'user') { // 1 means Deleted
                            $sql = "UPDATE user_table SET is_deleted = '1' WHERE user_id = '$user_id'";

                            if ($mysqli->query($sql) === TRUE) {
                                ?>
                    <script>
                        swal({
                            title: "Warning!",
                            text: "Your Account is Deleted!",
                            icon: "warning",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../index.php?logout=1";
                        });
                    </script>
                <?php
                            }
                        }

                        if ($account_type == 'worker') { // 1 means Deleted
                            $sql = "UPDATE worker_table SET is_deleted = '1' WHERE worker_id = '$worker_id'";

                            if ($mysqli->query($sql) === TRUE) {
                                ?>
                    <script>
                        swal({
                            title: "Warning!",
                            text: "Your Account is Deleted!",
                            icon: "warning",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../index.php?logout=1";
                        });
                    </script>
                <?php
                            }
                        }
                    }
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_GET['primary_category'])) {
                            if ($_SESSION['primary_category_id'] == $_POST["category"]) {
                                ?>
                    <script>
                        swal({
                            title: "Warning!",
                            text: "You have not changed your category!",
                            icon: "warning",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../setting.php";
                        });
                    </script>
                    <?php
                                } else {
                                    $primary_category = $_POST["category"];
                                    $sub_category_id = array();
                                    $serialized_array = serialize($sub_category_id);
                                    $sql = "UPDATE worker_table SET category_id = '$primary_category', sub_category_id = '$serialized_array' WHERE worker_id = '$worker_id'";
                                    $now = Carbon::now('Asia/Dhaka');

                                    if ($worker_setting_change_query->num_rows > 0) {
                                        $worker_setting_change_query_fetch = (int) $worker_setting_change_query_fetch + 1;
                                        $sqls = "UPDATE worker_settings_change_time SET number_of_changes = '$worker_setting_change_query_fetch' , last_change = '$now' WHERE worker_id = '$worker_id'";
                                    } else {
                                        $worker_setting_change_query_fetch = $worker_setting_change_query_fetch + 1;
                                        $sqls = "INSERT INTO `worker_settings_change_time`(`worker_id`, `number_of_changes`, `last_change`) VALUES ('$worker_id','$worker_setting_change_query_fetch','$now')";
                                    }

                                    if ($mysqli->query($sql) === TRUE && $mysqli->query($sqls) === TRUE) {
                                        ?>
                        <script>
                            swal({
                                title: "Success!",
                                text: "You have changed your primary category. Please go and update your sub category!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script>
                    <?php
                                    } else {
                                        ?>
                        <script>
                            swal({
                                title: "Error!",
                                text: "Something went wrong. Please try again!",
                                icon: "error",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../setting.php";
                            });
                        </script>
                    <?php
                                    }
                                }
                            }
                        }

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // This Module does not added
                            if (isset($_GET['smsSet'])) {
                                if ($account_type == 'user') { } else {
                                    $sms = $_POST['smsSet'];
                                    if ($sms == 1) {
                                        $update_sms_set = $mysqli->query("UPDATE worker_table SET is_sms_on = 1 WHERE worker_id = '$worker_id'");
                                    } else {
                                        $update_sms_set = $mysqli->query("UPDATE worker_table SET is_sms_on = 0 WHERE worker_id = '$worker_id'");
                                    }

                                    $sms_count = $mysqli->query("SELECT sms_count FROM worker_table WHERE worker_id = '$worker_id' ");
                                    $sms_count = $sms_count->fetch_assoc()['sms_count'];
                                    ?>
                    <script>
                        alert("You have <?= $sms_count; ?> sms left. Thank You.");
                        window.location.href = '../setting.php?';
                    </script>
                    <?php
                                }
                            }
                        }
                        //Code of worker and user verification file sumbmission
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_GET['verFile'])) {

                                if ($account_type == 'worker') {
                                    $file_type = $_POST['verFileType'];

                                    //image handle
                                    //Front Image
                                    $front_image_name = $_FILES['frontPic']['name'];
                                    $front_image_tmp_name = $_FILES['frontPic']['tmp_name'];
                                    $front_image_size = $_FILES['frontPic']['size'];
                                    $front_image_error = $_FILES['frontPic']['error'];
                                    $front_image_type = $_FILES['frontPic']['type'];

                                    $front_image_file_ext = explode('.', $front_image_name);
                                    $front_image_actual_ext = strtolower(end($front_image_file_ext));

                                    //Back Image
                                    $back_image_name = $_FILES['backPic']['name'];
                                    $back_image_tmp_name = $_FILES['backPic']['tmp_name'];
                                    $back_image_size = $_FILES['backPic']['size'];
                                    $back_image_error = $_FILES['backPic']['error'];
                                    $back_image_type = $_FILES['backPic']['type'];

                                    $back_image_file_ext = explode('.', $back_image_name);
                                    $back_image_actual_ext = strtolower(end($back_image_file_ext));

                                    $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf');

                                    if (in_array($front_image_actual_ext, $allowed) && in_array($back_image_actual_ext, $allowed)) {
                                        if ($front_image_error === 0 && $back_image_error === 0) {
                                            if ($front_image_size < 5000000 && $back_image_size < 5000000) {

                                                $front_image_file_name = uniqid('', true) . "." . $front_image_actual_ext;
                                                $front_file_destination = '../image/verFile/worker/' . $front_image_file_name;

                                                $back_image_file_name = uniqid('', true) . "." . $back_image_actual_ext;
                                                $back_file_destination = '../image/verFile/worker/' . $back_image_file_name;

                                                if (move_uploaded_file($front_image_tmp_name, $front_file_destination) && move_uploaded_file($back_image_tmp_name, $back_file_destination)) {
                                                    $ver_file_check = $mysqli->query("SELECT worker_id FROM worker_verification_file WHERE worker_id = '$worker_id'");
                                                    if ($ver_file_check->num_rows > 0) {
                                                        $update_file = $mysqli->query("UPDATE worker_verification_file SET file_type = $file_type, verification_file_front = $front_image_file_name,  verification_file_back = $back_image_file_name WHERE worker_id = '$worker_id'");
                                                    } else {
                                                        $insert_file = $mysqli->query("INSERT INTO worker_verification_file (worker_id,	file_type,	verification_file_front, verification_file_back) VALUES ('$worker_id', '$file_type', '$front_image_file_name', '$back_image_file_name')");
                                                    }
                                                    ?>
                                    <script>
                                        swal({
                                            title: "Success!",
                                            text: "Your files are updated. Thank You!",
                                            icon: "success",
                                            button: "OK",
                                            closeOnClickOutside: false
                                        }).then(function() {
                                            window.location = "../setting.php";
                                        });
                                    </script>
                                <?php

                                                            }
                                                        } else {
                                                            ?>
                                <script>
                                    swal({
                                        title: "Error!",
                                        text: "File should be less than or equal 4mb!",
                                        icon: "error",
                                        button: "OK",
                                        closeOnClickOutside: false
                                    }).then(function() {
                                        window.location = "../setting.php";
                                    });
                                </script>
                            <?php
                                                    }
                                                } else {
                                                    ?>
                            <script>
                                swal({
                                    title: "Error!",
                                    text: "Error uploading a file!",
                                    icon: "error",
                                    button: "OK",
                                    closeOnClickOutside: false
                                }).then(function() {
                                    window.location = "../setting.php";
                                });
                            </script>
                            <?php
                                                }
                                            }
                                        } else {
                                            $file_type = $_POST['verFileType'];

                                            //image handle
                                            //Front Image
                                            $front_image_name = $_FILES['frontPic']['name'];
                                            $front_image_tmp_name = $_FILES['frontPic']['tmp_name'];
                                            $front_image_size = $_FILES['frontPic']['size'];
                                            $front_image_error = $_FILES['frontPic']['error'];
                                            $front_image_type = $_FILES['frontPic']['type'];

                                            $front_image_file_ext = explode('.', $front_image_name);
                                            $front_image_actual_ext = strtolower(end($front_image_file_ext));

                                            //Back Image
                                            $back_image_name = $_FILES['backPic']['name'];
                                            $back_image_tmp_name = $_FILES['backPic']['tmp_name'];
                                            $back_image_size = $_FILES['backPic']['size'];
                                            $back_image_error = $_FILES['backPic']['error'];
                                            $back_image_type = $_FILES['backPic']['type'];

                                            $back_image_file_ext = explode('.', $back_image_name);
                                            $back_image_actual_ext = strtolower(end($back_image_file_ext));

                                            $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf');

                                            if (in_array($front_image_actual_ext, $allowed) && in_array($back_image_actual_ext, $allowed)) {
                                                if ($front_image_error === 0 && $back_image_error === 0) {
                                                    if ($front_image_size < 5000000 && $back_image_size < 5000000) {

                                                        $front_image_file_name = uniqid('', true) . "." . $front_image_actual_ext;
                                                        $front_file_destination = '../image/verFile/user/' . $front_image_file_name;

                                                        $back_image_file_name = uniqid('', true) . "." . $back_image_actual_ext;
                                                        $back_file_destination = '../image/verFile/user/' . $back_image_file_name;

                                                        if (move_uploaded_file($front_image_tmp_name, $front_file_destination) && move_uploaded_file($back_image_tmp_name, $back_file_destination)) {
                                                            $ver_file_check = $mysqli->query("SELECT user_id FROM user_verification_file WHERE user_id = '$user_id'");
                                                            if ($ver_file_check->num_rows > 0) {
                                                                $update_file = $mysqli->query("UPDATE user_verification_file SET file_type = $file_type, verification_file_front = $front_image_file_name,  verification_file_back = $back_image_file_name WHERE user_id = '$user_id'");
                                                            } else {
                                                                $insert_file = $mysqli->query("INSERT INTO user_verification_file (user_id,	file_type,	verification_file_front, verification_file_back) VALUES ('$user_id', '$file_type', '$front_image_file_name', '$back_image_file_name')");
                                                            }
                                                            ?>
                                    <script>
                                        swal({
                                            title: "Success!",
                                            text: "Your files are updated. Thank You!",
                                            icon: "success",
                                            button: "OK",
                                            closeOnClickOutside: false
                                        }).then(function() {
                                            window.location = "../setting.php";
                                        });
                                    </script>
                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                <script>
                                    swal({
                                        title: "Error!",
                                        text: "File should be less than or equal 4mb!",
                                        icon: "error",
                                        button: "OK",
                                        closeOnClickOutside: false
                                    }).then(function() {
                                        window.location = "../setting.php";
                                    });
                                </script>
                            <?php
                                                    }
                                                } else {
                                                    ?>
                            <script>
                                swal({
                                    title: "Error!",
                                    text: "Error uploading a file!",
                                    icon: "error",
                                    button: "OK",
                                    closeOnClickOutside: false
                                }).then(function() {
                                    window.location = "../setting.php";
                                });
                            </script>
    <?php
                        }
                    }
                }
            }
        }
    }

    ?>
</body>

</html>