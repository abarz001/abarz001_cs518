<?php
session_start();
require_once('favicon.php');
echo '<div class="links"><br><a href="index.php">Home Page</a><br>
<a href="logout.php">Logout</a></div>';
if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
    $valueUpdated = false;
    $currentEmail = $_SESSION['email'];
    if (!isset($_SESSION['ApprovedByAdmin']) || !$_SESSION['ApprovedByAdmin']) {
        echo 'Your account is currently pending approval by an admin. Please check back later to see if your account has been approved by an admin.';
        exit;
    } else {
        require 'changeinformation.php';
        $newValues = array();
        //Start updating profile if new values are set.
        if (!empty($_POST['currentPass'])) {
            require 'authenticate.php';

            if (authenticate($currentEmail, $_POST['currentPass'])){
            if (!empty($_POST['newEmail'])) {
                array_push($newValues, "Email = '" . $_POST['newEmail'] . "'");
            }
            if (!empty($_POST['newPass'])) {
                array_push($newValues, "Password = '" . md5($_POST['newPass']) . "'");
            }
            if (!empty($_POST['newFirstName'])) {
                array_push($newValues, "Name_First = '" . $_POST['newFirstName'] . "'");
            }
            if (!empty($_POST['newLastName'])) {
                array_push($newValues, "Name_Last = '" . $_POST['newLastName'] . "'");
            }
            if (!empty($_POST['newOrganization'])) {
                array_push($newValues, "Organization = '" . $_POST['newOrganization'] . "'");
            }
            }
            else {
            echo '<br><center>The current password you entered is incorrect. Your information was not updated. Please try again.<br></center>';
        };
        }
        
        if (!empty($newValues)) {
            if (updateValues($currentEmail, $_POST['currentPass'], $newValues)) {
                require 'logout.php';
            }
        }
        $userEmail = $_SESSION['email'];
        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];
        $organization = $_SESSION['organization'];
        $regDate = $_SESSION['regDate'];
        $lastLogin = $_SESSION['lastLogin'];
        $adminUser = $_SESSION['adminUser'];
        $emailVerified = $_SESSION['emailVerified'];
        $approvedByAdmin = $_SESSION['approvedByAdmin'];
    }
} else {
    header('Location: login.php');
    exit;
}
?>

<html>

<head>
    <title>Profile / User Information Change</title>
    <style>
        .profile {
            border-width: 5px;
            border-style: groove;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-40%, -40%);
            transform: translate(-50%, -65%);
        }
        .links {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="profile">
        <form action="" method="post" name="frmProfile" id="frmProfile">
            <table width="400" border="2" align="center" cellpadding="5" cellspacing="3">
                <tr>
                    <td width="150"></td>
                    <td><b>Current Value</b></td>
                    <td><b>New Value</b></td>
                </tr>
                <tr>
                    <td width="150">Email Address</td>
                    <td><?php echo $currentEmail ?></td>
                    <td><input name="newEmail" type="email" id="newEmail" value=""></td>
                </tr>
                <tr>
                    <td width="150">Password</td>
                    <td><input name="currentPass" type="password" id="currentPass" value="" required></td>
                    <td><input name="newPass" type="password" id="newPass" value=""></td>
                </tr>
                <tr>
                    <td width="150">First Name</td>
                    <td><?php echo $firstName ?></td>
                    <td><input name="newFirstName" type="text" id="newFirstName" value=""></td>
                </tr>
                <tr>
                    <td width="150">Last Name</td>
                    <td><?php echo $lastName ?></td>
                    <td><input name="newLastName" type="text" id="newLastName" value=""></td>
                </tr>
                <tr>
                    <td width="150">Organization</td>
                    <td><?php echo $organization ?></td>
                    <td><input name="newOrganization" type="text" id="newOrganization" value=""></td>
                </tr>
                                <tr>
                    <td width="150">Registration Date</td>
                    <td><?php echo $regDate ?></td>
                </tr>
                <tr>
                    <td width="150">Last Login</td>
                    <td><?php echo $lastLogin ?></td>
                </tr>
                <tr>
                    <td width="150">Admin User</td>
                    <td><?php if ($adminUser == 0) {
                            echo 'No';
                        } else if ($adminUser == 1) {
                            echo 'Yes';
                        } else {
                            echo 'Error';
                        } ?></td>
                </tr>
                <tr>
                    <td width="150">Email Verified</td>
                    <td><?php if ($emailVerified == false) {
                            echo 'No';
                        } else if ($emailVerified == true) {
                            echo 'Yes';
                        } else {
                            echo 'Error';
                        } ?></td>
                </tr>
                <tr>
                    <td width="150">Account Approved</td>
                    <td><?php if ($approvedByAdmin == false) {
                            echo 'No';
                        } else if ($approvedByAdmin == true) {
                            echo 'Yes';
                        } else {
                            echo 'Error';
                        } ?></td>
                </tr>
            </table>
            <tr>
                    <td colspan="3" >
                        <center><br><input name="btnUpdateValues" type="submit" id="btnUpdateValues" value="Update My Profile!">
                        </center>
                    </td>
            </tr>
            </table>
        </form>
    </div>
    <?php require_once('footer.php'); ?>
</body>

</html>