<html>

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php
    if (!isset($_SESSION)) session_start();
    require "dbConnection.php";

    if ($_SESSION['logged_in'] != 1) {
        #when not loggedin
        header("Location: ../index.php?not_logged_in");
    } else {
        #when logged in
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_GET['qId'])) {
                $qId = $_GET['qId'];
            }
            $job_id = $_SESSION['job_id'];
            $job_answer = $_POST['job_answer'];
            if (empty($job_answer)) {
                ?>
                <script>
                    swal({
                        title: "Error!",
                        text: "Your Answer is empty!",
                        icon: "error",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../jobDetails.php?jId=<?= $job_id ?>&error=true&jobStatus";
                    });
                </script>
                <?php
                        } else {
                            $sql = "INSERT into answer_table(question_id, answer)" .
                                "VALUES('$qId', '$job_answer')";
                            if ($mysqli->query($sql) === TRUE) {
                                ?>
                    <script>
                        swal({
                            title: "Done!",
                            text: "Your Answer has been sent!",
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