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
            $job_question = $_POST['job_question'];
            if (empty($job_question)) {
                ?>
                <script>
                    swal({
                        title: "Error!",
                        text: "Your Question is empty!",
                        icon: "error",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../jobDetails.php?jId=<?= $job_id ?>&error=true&jobStatus";
                    });
                </script>
                <?php
                        } else {
                            $sql = "INSERT into question_table(job_id, question)" .
                                "VALUES('$job_id', '$job_question')";
                            if ($mysqli->query($sql) === TRUE) {

                                if (isset($_GET['uId'])) {
                                    $uId = $_GET['uId'];
                                    userAskQuestion($job_id, $uId);
                                }

                                ?>
                    <script>
                        swal({
                            title: "Done!",
                            text: "Your Question has been sent!",
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
            }
        }
    }
    ?>

</body>

</html>