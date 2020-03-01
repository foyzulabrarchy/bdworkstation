<?php
require 'vendor/autoload.php';

use Carbon\Carbon;

$account_type = $_SESSION['account_type'];
$area_sql = $mysqli->query("SELECT * FROM area_table");
$session_area = $_SESSION['area'];

if ($account_type == 'worker') {
    $worker_id = $_SESSION['worker_id'];
    $ver_file_check = $mysqli->query("SELECT worker_id FROM worker_verification_file WHERE worker_id = '$worker_id'");

    if ($ver_file_check->num_rows > 0) {
        $ver_file_present = 1;
    } else {
        $ver_file_present = 0;
    }

    $ver_status_check = $mysqli->query("SELECT is_verified, area FROM worker_table WHERE worker_id = '$worker_id'");
    $ver_status = $ver_status_check->fetch_assoc()['is_verified'];
    $area_status = $ver_status_check->fetch_assoc()['area'];
    //code for time check for settings
    $check_set_time = $mysqli->query("SELECT number_of_changes, last_change FROM worker_settings_change_time WHERE worker_id = '$worker_id'");
    while ($row = $check_set_time->fetch_assoc()) {
        $number_of_changes = $row['number_of_changes'];
        $last_changed = $row['last_change'];
    }
   

   // checking time difference
    $current_time = Carbon::parse($last_changed, 'Asia/Dhaka');
    $time_difference_in_days = $current_time->diffInDays();
    $next_change_time = strtotime(date("Y-m-d H:i:s", strtotime($last_changed)) . " +1 month");
    $next_change_time = date("Y-m-d H:i:s", $next_change_time);


} else {
    $user_id = $_SESSION['user_id'];
    $ver_file_check = $mysqli->query("SELECT user_id FROM user_verification_file WHERE user_id = '$user_id'");

    if ($ver_file_check->num_rows > 0) {
        $ver_file_present = 1;
    } else {
        $ver_file_present = 0;
    }

    $ver_status_check = $mysqli->query("SELECT is_verified, area FROM user_table WHERE user_id = '$user_id'");
    $ver_status = $ver_status_check->fetch_assoc()['is_verified'];
    $area_status = $ver_status_check->fetch_assoc()['area'];
}
?>


<div id="generalSettingId" class="generalSettings">


    <div class="generalSet">
        <div class="row container">
            <div class="col-md-6 col-xs-6">
                <h5>Personal Info</h5>
            </div>
            <div class="col-md-5 col-xs-6">
                <p><?= $phone; ?></p>
            </div>
            <div class="col-md-1 col-xs-12">
                <button class="btn" onclick="SetGenFoSh('perInfo')">Edit</button>
            </div>
        </div>
        <div id="perInfoForm" class="genSetForm">
            <form action="backEnds/settingUpdate.php?pi" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" placeholder="<?= $full_name; ?>" disabled>
                    <label>Phone Number</label>
                    <input type="text" class="form-control" placeholder="<?= $phone; ?>" disabled>
                    <label>Address</label>
                    <input type="text" class="form-control" name="update_address" value="<?= $address; ?>" required>
                    <label>Area</label><br>
                    <select id="area" name="area" required>
                        <?php while ($row = $area_sql->fetch_assoc()) : ?>
                            <?php
                                $parent_id = $row['area_id'];
                                $parent_name = $row['area_name'];
                                ?>
                            <?php
                                if ($parent_id == $session_area) {
                                    ?>
                                <option name="itemFor" value="<?= $parent_id; ?>" selected> <?= $parent_name ?> </option>
                            <?php } else { ?>
                                <option name="itemFor" value="<?= $parent_id; ?>">
                                    <?= $parent_name; ?>
                                </option>
                        <?php }
                        endwhile;
                        ?>
                    </select>
                    <br><br>





                    <button type="submit" class="btn btn-success">SAVE</button>
                    <button type="button" class="btn btn-danger" onclick="SetGenFoCl('perInfo')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="generalSet">
        <div class="row container">
            <div class="col-md-6 col-xs-6">
                <h5>Password</h5>
            </div>
            <div class="col-md-5 col-xs-6">
                <p>************</p>
            </div>
            <div class="col-md-1 col-xs-12">
                <button class="btn" onclick="SetGenFoSh('pwd')">Edit</button>
            </div>
        </div>
        <div id="pwdForm" class="genSetForm">
            <form action="backEnds/settingUpdate.php?pwd" method="POST">
                <div class="form-group">
                    <label>Current Password</label><br>
                    <input type="password" class="form-control" name="oldPwd"><br>
                    <label>New Password</label><br>
                    <input type="password" class="form-control" name="pwdForm"><br>
                    <label>Confirm Password</label><br>
                    <input type="password" class="form-control" name="ConPwdForm"><br>
                    <button type="submit" class="btn btn-success">SAVE</button>
                    <button type="button" class="btn btn-danger" onclick="SetGenFoCl('pwd')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="generalSet">
        <div class="row container">
            <div class="col-md-6 col-xs-6">
                <h5>Account</h5>
            </div>
            <div class="col-md-5 col-xs-6">
                <p>Active</p>
            </div>
            <div class="col-md-1 col-xs-12">
                <button class="btn" onclick="SetGenFoSh('acc')">Edit</button>
            </div>
        </div>
        <div id="accForm" class="genSetForm">
            <!-- <form action="#"> -->
            <div class="form-group">
                <label>Deactivate Your Accout</label>
                <a href="backEnds/settingUpdate.php?deactive"><button type="submit" class="btn btn-primary" name="">Deactive</button></a><br><br>
                <label>Delete Your Accout</label>
                <a href="backEnds/settingUpdate.php?delete"><button type="submit" class="btn btn-primary" name="">Delete</button></a><br><br>
                <button type="button" class="btn btn-danger" onclick="SetGenFoCl('acc')">Cancel</button>
            </div>
            <!-- </form> -->
        </div>
    </div>

    <?php
    if ($account_type == 'worker') {
        ?>
        <!-- Primary Category  -->
        <div class="generalSet">
            <div class="row container">
                <div class="col-md-6 col-xs-6">
                    <h5>Primary Category</h5>
                </div>
                <div class="col-md-5 col-xs-6">
                    <p><?= $category_name; ?></p>
                </div>
                <div class="col-md-1 col-xs-12">
                    <button class="btn" onclick="SetGenFoSh('prCat')">Edit</button>
                </div>
            </div>
            <div id="prCatForm" class="genSetForm">
                <form action="backEnds/settingUpdate.php?primary_category" method="POST">
                    <div class="form-group">
                        <label>Please select your primary category of work</label><br>
                        <select id="category" name="category" required>
                            <!-- <option disabled selected value> <?= $_SESSION['primary_category'] ?> </option> -->
                            <?php while ($row = mysqli_fetch_array($categories)) : ?>
                                <?php
                                        $parent_id = $row['category_id'];
                                        $parent_name = $row['category_name'];
                                        ?>
                                <?php
                                        if ($parent_id == $category_id) {
                                            ?>
                                    <option name="itemFor" value="<?= $parent_id; ?>" selected> <?= $category_name ?> </option>
                                <?php } else { ?>
                                    <option name="itemFor" value="<?= $parent_id; ?>">
                                        <?= $parent_name; ?>
                                    </option>
                            <?php }
                                endwhile;
                                ?>
                        </select>
                        <br><br>

                        <?php
                            if ($number_of_changes > 0) {
                                if ($time_difference_in_days <= 30) { ?>
                                <button type="submit" class="btn btn-success" disabled>SAVE</button>
                                <button type="button" class="btn btn-danger" onclick="SetGenFoCl('prCat')">Cancel</button>
                                <p>You have changed your category recently. You can change it once per month.<br> You can change your category on <?=
                                $next_change_time; 
                                ?></p>
                            <?php
                                    } else { ?>
                                <button type="submit" class="btn btn-success">SAVE</button>
                                <button type="button" class="btn btn-danger" onclick="SetGenFoCl('prCat')">Cancel</button>
                            <?php
                                    }
                                } else { ?>
                            <button type="submit" class="btn btn-success">SAVE</button>
                            <button type="button" class="btn btn-danger" onclick="SetGenFoCl('prCat')">Cancel</button>
                        <?php
                            }

                            ?>


                    </div>
                </form>
            </div>
        </div>

        <!-- Sub Category  -->
        <div class="generalSet">
            <div class="row container">
                <div class="col-md-6 col-xs-6">
                    <h5>Sub-Category</h5>
                </div>
                <div class="col-md-5 col-xs-6">
                    <p>Sub Category of your primary Category</p>
                </div>
                <div class="col-md-1 col-xs-12">
                    <button class="btn" onclick="SetGenFoSh('subCat')">Edit</button>
                </div>
            </div>
            <div id="subCatForm" class="genSetForm">
                <form action="backEnds/add_subcategory.php?wId=<?= $worker_id ?>" method="POST">
                    <div class="form-group">
                        <label>Please select your sub category of work</label><br>
                        <?php
                            $existing_sub_category = $mysqli->query("SELECT sub_category_id FROM worker_table WHERE worker_id = '$worker_id'");
                            while ($row = $existing_sub_category->fetch_assoc()) {
                                $sub_category_id = $row['sub_category_id']; // Serialized array
                                $sub_category_id = unserialize($sub_category_id); // convert to Unserialized array
                                $count = sizeof($sub_category_id); // How many values in the array
                            }

                            $category_id_check = $mysqli->query("SELECT category_id FROM worker_table WHERE worker_id = '$worker_id'");
                            $cate_id = $category_id_check->fetch_assoc()['category_id'];
                            $subCategory_id_check = $mysqli->query("SELECT * FROM sub_category_table WHERE category_id = '$cate_id'");
                            ?>
                        <div class="settingSubCateSelect">
                            <?php
                                while ($row = $subCategory_id_check->fetch_assoc()) {
                                    $show = 1;
                                    if ($count > 0) {
                                        for ($i = 0; $i < $count; $i++) {
                                            if ($sub_category_id[$i] == $row['sub_category_id']) {
                                                $show = 0;
                                                break;
                                            } else {
                                                $show = 1;
                                            }
                                        }
                                    }
                                    if ($show == 1) {
                                        ?>
                                    <input type='checkbox' name="sub[]" value="<?= $row['sub_category_id']; ?>"> <?= $row['sub_category_name']; ?>
                                    <br><br>

                            <?php
                                    }
                                }
                                ?>

                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">SAVE</button>
                        <button type="button" class="btn btn-danger" onclick="SetGenFoCl('subCat')">Cancel</button>

                    </div>
                </form>
            </div>
        </div>

    <?php } ?>
    <div class="generalSet">
        <div class="row container">
            <div class="col-md-6 col-xs-6">
                <h5>Upload Verification File</h5>
            </div>
            <div class="col-md-5 col-xs-6">
                <?php
                if ($ver_file_present == 1 && $ver_status == 1) {
                    ?>
                    <p>You are verified</p>
                <?php
                } elseif ($ver_file_present == 1 && $ver_status == 0) {
                    ?>
                    <p>Your files are submited. Verification must take upto 2 working days</p>
                <?php
                } else {
                    ?>
                    <p>NID / Driving Licence / Passport</p>
                <?php
                }
                ?>
            </div>
            <div class="col-md-1 col-xs-12">
                <?php
                if ($ver_file_present == 1) { } else {
                    ?>
                    <button class="btn" onclick="SetGenFoSh('verFile')">Edit</button>
                <?php
                }
                ?>

            </div>
        </div>
        <div id="verFileForm" class="genSetForm">
            <?php
            if ($ver_file_present == 0 && $ver_status == 0) { ?>


                <form action="backEnds/settingUpdate.php?verFile" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Select File Type</label><br>
                        <select name="verFileType" id="verFileType" required>
                            <option disabled selected value>---Select One---</option>
                            <option name="itemFor" value="NID">NID</option>
                            <option name="itemFor" value="DL">Driving Licence</option>
                            <option name="itemFor" value="PASS">Passport</option>
                        </select><br>
                        <label>Front Side / File 1 *</label>
                        <input type="file" class="form-control" name="frontPic" accept=".png, .jpg, .jpeg, .doc, .docx, .pdf" required>
                        <label>Back Side / File 2 *</label>
                        <input type="file" class="form-control" name="backPic" accept=".png, .jpg, .jpeg, .doc, .docx, .pdf" required><br>
                        <button type="submit" class="btn btn-success">SAVE</button>
                        <button type="button" class="btn btn-danger" onclick="SetGenFoCl('verFile')">Cancel</button>
                        <br><br>
                        <strong>Note: Only png, jpg, jpeg, doc, docx and pdf accepted. Make sure that your file name is small and file size is not more than 5mb.</strong>
                    </div>
                </form>

            <?php
            } elseif ($ver_file_present == 1 && $ver_status == 0) { ?>
                <br>
                <strong>Your files are submited. Verification must take upto 2 working days.</strong>
            <?php
            } elseif ($ver_file_present == 1 && $ver_status == 1) { ?>
                <br>
                <strong><i class="fas fa-user-check verifiedSign"></i> You are verified.</strong>
            <?php
            }
            ?>
        </div>
    </div>
</div>