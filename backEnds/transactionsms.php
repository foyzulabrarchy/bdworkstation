<html>


<body>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    if (!isset($_SESSION)) session_start();
    require "dbConnection.php";
    require "workerNotificationEntry.php";

    if ($_SESSION['logged_in'] != 1) {
        #when not loggedin
        header("Location: ../index.php?not_logged_in");
    } else {
        #when logged in

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /* PHP */
            $post_data = array();
            $post_data['store_id'] = "works5d7258b389282";
            $post_data['store_passwd'] = "works5d7258b389282@ssl";
            $package_id = $_POST['smsPackageSelect']; //work db
            $_SESSION['package_id'] = $package_id;
            $package_price_sql = $mysqli->query("SELECT package_price FROM sms_package WHERE id='$package_id'");
            while ($row = $package_price_sql->fetch_assoc()) {
                $package_price = $row['package_price'];
            }
            $post_data['total_amount'] = $package_price;
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = "sms_bdworkstation_" . uniqid();
            $transaction_id = $post_data['tran_id']; //work db
            $_SESSION['transaction_id'] = $transaction_id;
            $post_data['success_url'] = "http://localhost/bdworkstation/buyCredits.php?success";
            $post_data['fail_url'] = "http://localhost/bdworkstation/buyCredits.php?failed";
            $post_data['cancel_url'] = "http://localhost/bdworkstation/buyCredits.php?cancelled";
            $worker_id = $_SESSION['worker_id'];


            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $_SESSION['first_name'];
            $post_data['cus_add1'] = $_SESSION['address'];
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = $_SESSION['phone'];

            $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $direct_api_url);
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


            $content = curl_exec($handle);

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if ($code == 200 && !(curl_errno($handle))) {
                curl_close($handle);
                $sslcommerzResponse = $content;
            } else {
                curl_close($handle);
                echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                exit;
            }

            # PARSE THE JSON RESPONSE
            $sslcz = json_decode($sslcommerzResponse, true);

            if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
                # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
                # header("Location: ". $sslcz['GatewayPageURL']);
                exit;
            } else {
                echo "JSON Data parsing error!";
            }
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
                    window.location = "../buyCredits.php";
                });
            </script>

    <?php
        }
    }
    ?>

</body>

</html>