<?php

//Through this page we can access the user details
//As well as edit and update their details
//Or delete the record from the database.

session_start();
$_TITLE = "WPBTS - User Management";
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
include_once("address_functions.php");

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active"><a href="users.php">User Management</a></li>
            <li class="active">Create User</li>
        </ol>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Create new user:</h1>
        </div>
    </div><!--/.row-->

    <?php
    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong> <?php echo $_SESSION['alert']["message"] ?>
        </div>
        <?php
        if ($_SESSION['alert']["message_title"] == "Email exists!") {
            $wasEmailError = true;
        } elseif ($_SESSION['alert']["message_title"] == "Address write error!") {
            $wasAddressError = true;
        } elseif ($_SESSION['alert']["message_title"] == "User data write error!") {
            $wasUserError = true;
        }
        $_SESSION['alert'] = null;
    }
    ?>

    <?php
    //get the latest ID from the users table and use this for the new user. (+1)
    if (isset($_SESSION['USER']['USER_ID']) == false) {
        $userKey = getLastIDForTable() + 1;
        $_SESSION['USER']['USER_ID'] = $userKey;
    }
    ?>


    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h3>User Details:</h3>
            <form action="php/form-handler-user-createuser.php" method="POST">
                <div class="col-md-6">
                    <label>User ID</label>
                    <input required readonly type="text"
                           class="form-control" name="USER_ID" value="<?php echo $_SESSION['USER']['USER_ID'] ?>"
                           style="margin-bottom:2%">

                    <label>First Name</label>
                    <input required type="text"
                           class="form-control" name="FIRST_NAME" value="<?php echo $_SESSION['USER']['FIRST_NAME'] ?>"
                           style="margin-bottom:2%">

                    <label>Last Name</label>
                    <input required type="text"
                           class="form-control" name="LAST_NAME"
                           value="<?php echo $_SESSION['USER']['LAST_NAME'] ?>"
                           style="margin-bottom:2%">

                    <label style="color:<?php if ($wasUserError) {
                        echo "darkred";
                    } ?>">National ID<?php if ($wasUserError) {
                            echo " (Numeric Only)";
                        } ?></label></label>
                    <input required type="text"
                           class="form-control" name="NATIONAL_ID"
                           value="<?php echo $_SESSION['USER']['NATIONAL_ID'] ?>"
                           style="margin-bottom:2%">

                    <label style="color:<?php if ($wasEmailError) {
                        echo "darkred";
                    } ?>">Email</label>
                    <input required type="email"
                           class="form-control" name="EMAIL" value="<?php echo $_SESSION['USER']['EMAIL'] ?>"
                           style="margin-bottom:2%">


                    <label style="color:<?php if ($wasAddressError) {
                        echo "darkred";
                    } ?>">Street Number<?php if ($wasAddressError) {
                            echo " (Numeric Only)";
                        } ?></label>
                    <input required type="text"
                           class="form-control" name="STREET_NO" value="<?php echo $_SESSION['USER']['STREET_NO'] ?>"
                           style="margin-bottom:2%">

                    <label>Street</label>
                    <input required type="text"
                           class="form-control" name="STREET" value="<?php echo $_SESSION['USER']['STREET'] ?>"
                           style="margin-bottom:2%">

                    <label>Office</label>
                    <input required type="text"
                           class="form-control" name="OFFICE" value="<?php echo $_SESSION['USER']['OFFICE'] ?>"
                           style="margin-bottom:2%">


                    <label style="color:<?php if ($wasAddressError) {
                        echo "darkred";
                    } ?>">Building Number<?php if ($wasAddressError) {
                            echo " (Numeric Only)";
                        } ?></label>
                    <input required type="text"
                           class="form-control" name="BUILDING_NUMBER"
                           value="<?php echo $_SESSION['USER']['BUILDING_NUMBER'] ?>" style="margin-bottom:2%">

                    <label>Password</label>
                    <input required type="text"
                           class="form-control" name="PASSWORD"
                           value="<?php echo $_SESSION['USER']['PASSWORD'] ?>" style="margin-bottom:2%">

                </div>

                <div class="col-md-6">

                    <label>Title</label>
                    <input required type="text"
                           class="form-control" name="TITLE"
                           value="<?php echo $_SESSION['USER']['TITLE'] ?>" style="margin-bottom:2%">

                    <label>Date of Birth</label>
                    <input required="" type="date" class="form-control daterange hasDatepicker" id="DATE_OF_BIRTH"
                           name="DATE_OF_BIRTH"
                           value="<?php echo date_format(date_create($_SESSION['USER']['DATE_OF_BIRTH']), 'Y-m-d') ?>"
                           style="margin-bottom: 2%">

                    <label>Blood Type</label>
                    <select required type="text" value="<?php echo $_SESSION['USER']['BLOOD_TYPE'] ?>"
                            class="form-control" name="BLOOD_TYPE"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="O-"
                            <?php
                            if ($_SESSION['BLOOD_TYPE'] == "O-") {
                                echo "selected";
                            }
                            ?>
                        >
                            O-
                        </option>
                        <option value="O+"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "O+") {
                                echo "selected";
                            }
                            ?>
                        >O+
                        </option>
                        <option value="A"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "A") {
                                echo "selected";
                            }
                            ?>
                        >A
                        </option>
                        <option value="A+"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "A+") {
                                echo "selected";
                            }
                            ?>
                        >A+
                        </option>
                        <option value="AB"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "AB") {
                                echo "selected";
                            }
                            ?>
                        >AB
                        </option>
                        <option value="AB+"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "AB+") {
                                echo "selected";
                            }
                            ?>
                        >AB+
                        </option>
                        <option value="B-"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "B-") {
                                echo "selected";
                            }
                            ?>
                        >B-
                        </option>
                        <option value="OB"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "OB") {
                                echo "selected";
                            }
                            ?>
                        >OB
                        </option>
                    </select>

                    <label>Gender:</label>
                    <select required type="text" value="<?php echo $_SESSION['USER']['GENDER'] ?>" class="form-control"
                            name="GENDER"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="M"
                            <?php
                            if ($_SESSION['USER']['GENDER'] == "M") {
                                echo "selected";
                            }
                            ?>
                        >Male
                        </option>
                        <option value="F"
                            <?php
                            if ($_SESSION['USER']['GENDER'] == "F") {
                                echo "selected";
                            }
                            ?>
                        >Female
                        </option>
                    </select>


                    <label>Language:</label>
                    <select required type="text" value="<?php echo $_SESSION['USER']['LANGUAGE_PREF'] ?>"
                            class="form-control" name="LANGUAGE_PREF"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="English"
                            <?php
                            if ($_SESSION['USER']['LANGUAGE_PREF'] == "English") {
                                echo "selected";
                            }
                            ?>
                        >English
                        </option>
                        <option value="Afrikaans"
                            <?php
                            if ($_SESSION['USER']['LANGUAGE_PREF'] == "Afrikaans") {
                                echo "selected";
                            }
                            ?>
                        >Afrikaans
                        </option>
                        <option value="Xhosa"
                            <?php
                            if ($_SESSION['USER']['LANGUAGE_PREF'] == "Xhosa") {
                                echo "selected";
                            }
                            ?>
                        >Xhosa
                        </option>
                        <option value="Zulu"
                            <?php
                            if ($_SESSION['USER']['LANGUAGE_PREF'] == "Zulu") {
                                echo "selected";
                            }
                            ?>
                        >Zulu
                        </option>
                    </select>

                    <label style="color:<?php if ($wasUserError) {
                        echo "darkred";
                    } ?>">Phone<?php if ($wasUserError) {
                            echo " (Numeric Only)";
                        } ?></label></label>
                    <input required type="text"
                           class="form-control" name="PHONE" value="<?php echo $_SESSION['USER']['PHONE'] ?>"
                           style="margin-bottom:2%">

                    <label style="color:<?php if ($wasUserError) {
                        echo "darkred";
                    } ?>">Passport Number<?php if ($wasUserError) {
                            echo " (Numeric Only)";
                        } ?></label></label>
                    <input required type="text"
                           class="form-control" name="PASSPORT_NO"
                           value="<?php echo $_SESSION['USER']['PASSPORT_NO'] ?>"
                           style="margin-bottom:2%">

                    <label>Area</label>
                    <input required type="text"
                           class="form-control" name="AREA" value="<?php echo $_SESSION['USER']['AREA'] ?>"
                           style="margin-bottom:2%">

                    <label>Area Code</label>
                    <input required type="text"
                           class="form-control" name="AREA_CODE" value="<?php echo $_SESSION['USER']['AREA_CODE'] ?>"
                           style="margin-bottom:2%">

                    <label>City</label>
                    <input required type="text"
                           class="form-control" name="CITY" value="<?php echo $_SESSION['USER']['CITY'] ?>"
                           style="margin-bottom:7%">

                    <div class="col-md-12" align="right" style="margin-bottom: 5%">
                        <button type="submit" class="btn btn-info">Save User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>


</div>    <!--/.main-->


<script>

    $("#eventdate").datepicker({dateFormat: "dd-mm-yy"}); //sets date picker format

    function validateNumberIn(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

</script>

<?php require_once('footer.php'); ?>


</body>

</html>

