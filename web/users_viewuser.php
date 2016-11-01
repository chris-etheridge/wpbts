<?php

//Through this page we can access the user details
//As well as edit and update their details
//Or delete the record from the database.

$_TITLE = "WPBTS - User Management";
$_PARENT['users'] = time();
require_once("header.php");
require_once('php/DBConn_Dave.php');
include_once("users_functions.php");
include_once("address_functions.php");

session_start();

//Lets get the user details from the database via the GET variable passed in from user management:
$userData = getUser($_GET['userID']);

$addressData = getAddress($userData[1][0]['ADDRESS_ID']);


//SETUP SESSION VARIABLES:
$_SESSION['USER']['USER_ID'] = $userData[1][0]['USER_ID'];
$_SESSION['USER']['FIRST_NAME'] = $userData[1][0]['FIRST_NAME'];
$_SESSION['USER']['LAST_NAME'] = $userData[1][0]['LAST_NAME'];
$_SESSION['USER']['NATIONAL_ID'] = $userData[1][0]['NATIONAL_ID'];
$_SESSION['USER']['EMAIL'] = $userData[1][0]['EMAIL'];
$_SESSION['USER']['PHONE'] = $userData[1][0]['PHONE'];
$_SESSION['USER']['STREET_NO'] = $addressData[1][0]['STREET_NO'];
$_SESSION['USER']['STREET'] = $addressData[1][0]['STREET'];
$_SESSION['USER']['OFFICE'] = $addressData[1][0]['OFFICE'];
$_SESSION['USER']['BUILDING_NUMBER'] = $addressData[1][0]['BUILDING_NUMBER'];
$_SESSION['USER']['DATE_OF_BIRTH'] = $userData[1][0]['DATEOF_BIRTH'];
$_SESSION['USER']['BLOOD_TYPE'] = $userData[1][0]['BLOOD_TYPE'];
$_SESSION['USER']['GENDER'] = $userData[1][0]['GENDER'];
$_SESSION['USER']['LANGUAGE_PREF'] = $userData[1][0]['LANGUAGE_PREF'];
$_SESSION['USER']['PASSPORT_NO'] = $userData[1][0]['PASSPORT_NO'];
$_SESSION['USER']['AREA'] = $addressData[1][0]['AREA'];
$_SESSION['USER']['AREA_CODE'] = $addressData[1][0]['AREA_CODE'];
$_SESSION['USER']['CITY'] = $addressData[1][0]['CITY'];
$_SESSION['USER']['PWD'] = $userData[1][0]['PWD'];
$_SESSION['USER']['TITLE'] = $userData[1][0]['TITLE'];
$_SESSION['USER']['LAST_EMAIL'] = $userData[1][0]['EMAIL'];


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
            <li class="active">View User</li>
        </ol>
    </div><!--/.row-->

    <?php
    if ($userData[0] == false) {
        //IF THE DATABASE HAD AN ERROR, SHOW HTML WITH MESSAGE
        //And dont load more of the page.
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>DB Error:</strong> <?php echo $userData[1] ?>
        </div>
        <?php
    } else {

    if (isset($_SESSION['alert'])) {
        ?>
        <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong><?php echo $_SESSION['alert']["message_title"] ?></strong></div>
        <?php
        $_SESSION['alert'] = null;
    }

    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                User:<?php echo $userData[1][0]['FIRST_NAME'] . " " . $userData[1][0]['LAST_NAME'] ?></h1>
        </div>
    </div><!--/.row-->

    <div class="row"> <!-- upcoming events -->
        <div class="col-md-12">
            <h3>User Details:</h3>

            <form action="php/form-handler-user-edit.php" method="POST">
                <div class="col-md-6">

                    <input required type="text" value="<?php echo $_SESSION['USER']['LAST_EMAIL'] ?>"
                           name="LAST_EMAIL" style="margin-bottom:2%" hidden>

                    <label>User ID</label>
                    <input required readonly type="text" value="<?php echo $_SESSION['USER']['USER_ID'] ?>"
                           class="form-control" name="USER_ID" style="margin-bottom:2%">

                    <label>Title:</label>
                    <input required type="text" value="<?php echo $_SESSION['USER']['TITLE'] ?>"
                           class="form-control"
                           name="TITLE" style="margin-bottom:2%">

                    <label>First Name:</label>
                    <input required type="text" value="<?php echo $_SESSION['USER']['FIRST_NAME'] ?>"
                           class="form-control"
                           name="FIRST_NAME"
                           style="margin-bottom:2%">

                    <label>Last Name:</label>
                    <input required type="text" value="<?php echo $_SESSION['USER']['LAST_NAME'] ?>"
                           class="form-control"
                           name="LAST_NAME"
                           style="margin-bottom:2%">

                    <label>National ID:</label>
                    <input required type="text" value="<?php echo $_SESSION['USER']['NATIONAL_ID'] ?>"
                           class="form-control" name="NATIONAL_ID"
                           style="margin-bottom:2%">

                    <label>Email:</label>
                    <input required type="text" value="<?php echo $_SESSION['USER']['EMAIL'] ?>" class="form-control"
                           name="EMAIL"
                           style="margin-bottom:2%">


                </div>
                <div class="col-md-6">

                    <label>Date of Birth</label>
                    <input required="" type="date" class="form-control daterange hasDatepicker" id="DATE_OF_BIRTH"
                           name="DATE_OF_BIRTH"
                           value="<?php echo date_format(date_create($_SESSION['USER']['DATE_OF_BIRTH']), 'Y-m-d') ?>"
                           style="margin-bottom: 2%">


                    <label>Blood Type::</label>
                    <select required type="text" value="<?php echo $_SESSION['USER']['BLOOD_TYPE'] ?>"
                            class="form-control" name="BLOOD_TYPE"
                            style="margin-bottom:2%">
                        <option value="-1" disabled>Select one--</option>
                        <option value="O-"
                            <?php
                            if ($_SESSION['USER']['BLOOD_TYPE'] == "O-") {
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
                    } ?>">Passport Number<?php if ($wasUserError) {
                            echo " (Numeric Only)";
                        } ?></label></label>
                    <input required type="text"
                           class="form-control" name="PASSPORT_NO"
                           value="<?php echo $_SESSION['USER']['PASSPORT_NO'] ?>"
                           style="margin-bottom:2%">

                    <label style="color:<?php if ($wasUserError) {
                        echo "darkred";
                    } ?>">Phone<?php if ($wasUserError) {
                            echo " (Numeric Only)";
                        } ?></label></label>
                    <input required type="text"
                           class="form-control" name="PHONE" value="<?php echo $_SESSION['USER']['PHONE'] ?>"
                           style="margin-bottom:2%">
                </div>

                <div class="col-md-6">

                    <input type="text" name="ADDRESS_ID" value="<?php echo $userData[1][0]['ADDRESS_ID'] ?>" hidden>

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
                </div>
                <div class="col-md-6">
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
                           style="margin-bottom:2%">

                    <label>Password</label>
                    <input required type="text"
                           class="form-control" name="PASSWORD"
                           value="p4ssw0rd" style="margin-bottom:7%">

                    <div class="col-md-12" align="right" style="margin-bottom: 5%">
                        <button type="submit" class="btn btn-info">Save User</button>
                    </div>
                </div>
            </form>

            <!--            <form>-->
            <!--                <div class="col-md-6">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Title</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['TITLE'] ?><!--" name="TITLE" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>First Name</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['FIRST_NAME'] ?><!--" name="FIRST_NAME"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Last Name</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['LAST_NAME'] ?><!--" name="LAST_NAME"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>National ID-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['NATIONAL_ID'] ?><!--" name="NATIONAL_ID"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Email</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['EMAIL'] ?><!--" name="EMAIL" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Phone</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['PHONE'] ?><!--" name="PHONE" style="width: 70%">-->
            <!---->
            <!--                </div>-->
            <!--                <div class="col-md-6">-->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Date of Birth-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['DATE_OF_BIRTH'] ?><!--" name="DATE_OF_BIRTH"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Blood Type</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $_SESSION['USER']['BLOOD_TYPE']?><!--" name="BLOOD_TYPE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Gender</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['GENDER'] ?><!--" name="GENDER" style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Language</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['LANGUAGE_PREF'] ?><!--" name="LANGUAGE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 20%" disabled>Passport</button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $userData[1][0]['PASSPORT_NUM'] ?><!--" name="PASSPORT_NUM"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <input type="text" name="USER_ID" value="-->
            <?php //echo $userData[1][0]['USER_ID'] ?><!--">-->
            <!---->
            <!--                </div>-->
            <!---->
            <!--                <div class="col-md-12" style="margin-top: 1%">-->
            <!---->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street Number-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['STREET_NO'] ?><!--" name="STREET_NO"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Street-->
            <!--                    </button>-->
            <!---->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['STREET'] ?><!--" name="STREET"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" value="--><?php //echo $addressData[1][0]['OFFICE'] ?><!--"-->
            <!--                            class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Office-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['OFFICE'] ?><!--" name="OFFICE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Building Number-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['BUILDING_NUMBER'] ?><!--"-->
            <!--                           name="BUILDING_NUMBER"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['AREA'] ?><!--" name="AREA"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>Area Code-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['AREA_CODE'] ?><!--" name="AREA_CODE"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <button type="button" class="btn btn-xs btn-primary" style="width: 25.2%" disabled>City-->
            <!--                    </button>-->
            <!--                    <input type="text" value="-->
            <?php //echo $addressData[1][0]['CITY'] ?><!--" name="City"-->
            <!--                           style="width: 70%">-->
            <!---->
            <!--                    <input type="text" name="USER_ID" value="-->
            <?php //echo $addressData[1][0]['ADDRESS_ID'] ?><!--">-->
            <!---->
            <!--                </div>-->
            <!---->
            <!--            </form>-->

        </div>
    </div>
</div>
    </div>
    </div>
    </div>


    </div>    <!--/.main-->
<?php
}
?>


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

