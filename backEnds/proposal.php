<html>

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>



    <?php
    if (!isset($_SESSION)) session_start();
    require "dbConnection.php";
    require "userNotificationEntry.php";

    if ($_SESSION['logged_in'] != 1) {
        #when not loggedin
        header("Location: ../index.php?not_logged_in");
    } else {
        #when logged in
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $job_id = $_SESSION['job_id'];

            $job_cat_check = $mysqli->query("SELECT category_id FROM job_table WHERE job_id = '$job_id'");
            $job_cat_id = $job_cat_check->fetch_assoc()['category_id'];

            // Search User to Notify
            $user_search = $mysqli->query("SELECT user_id FROM job_table WHERE job_id = '$job_id'");
            $uId = $user_search->fetch_assoc()['user_id'];

            $job_id_check = $mysqli->query("SELECT * FROM hire_table WHERE job_id= '$job_id'");
            if ($job_id_check->num_rows > 0) {
                ?>
                <script>
                    swal({
                        title: "Error!",
                        text: "Someone is already hired for the job!",
                        icon: "error",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../browsejob.php";
                    });
                </script>
                <?php
                        } else {
                            $proposal_price = $_POST['proposal_price'];
                            $phone = $_SESSION['phone'];
                            $acc_check = $mysqli->query("SELECT * FROM worker_table where phone_number = $phone");
                            while ($row = $acc_check->fetch_assoc()) {
                                $worker_id = $row['worker_id'];
                                $worker_cat_id = $row['category_id'];
                            }


                            if ($job_cat_id == $worker_cat_id || empty($job_cat_id)) {

                                if ($acc_check->num_rows > 0) {

                                    $sql = "INSERT into proposal_table(job_id, worker_id, proposal_price)" .
                                        "VALUES('$job_id', '$worker_id', '$proposal_price')";
                                }
                                if ($mysqli->query($sql) === TRUE) {

                                    userNotifyProposal($job_id, $uId);
                                    ?>
                        <script>
                            swal({
                                title: "Success!",
                                text: "Your proposal has been sent!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "../jobDetails.php?jId=<?= $job_id ?>&jobStatus";
                            });
                        </script>
                    <?php
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
                                window.location = "../jobDetails.php?jId=<?= $job_id ?>&error=true&jobStatus";
                            });
                        </script>
                    <?php
                                    }
                                } else {
                                    ?>
                    <script>
                        swal({
                            title: "Error!",
                            text: "Category do not match!",
                            icon: "error",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "../jobDetails.php?jId=<?= $job_id ?>&error=true&jobStatus";
                        });
                    </script>
            <?php
                        }
                    }
                } else {
                    ?>
            <script>
                swal({
                    title: "Error!",
                    text: "Request failed!",
                    icon: "error",
                    button: "OK",
                    closeOnClickOutside: false
                }).then(function() {
                    window.location = "../jobDetails.php?jId=<?= $job_id ?>&error=true&jobStatus";
                });
            </script>
    <?php
        }
    }
    ?>

</body>

</html>