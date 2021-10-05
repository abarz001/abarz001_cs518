<?php
session_start();

if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
    $userEmail = $_SESSION['email'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $organization = $_SESSION['organization'];
    $lastLogin = $_SESSION['lastLogin'];
    $adminUser = $_SESSION['adminUser'];
    $emailVerified = $_SESSION['emailVerified'];
    $approvedByAdmin = $_SESSION['approvedByAdmin'];
    //For Debugging 
    //echo 'Logged in as: ' . '<br><br>' . $userEmail . '.<br>' . md5($userEmail . $lastLogin) . '<br>' . $lastLogin;
    if (isset($_SESSION['emailVerified']) && $_SESSION['emailVerified']) {
        if (isset($_SESSION['ApprovedByAdmin']) && $_SESSION['ApprovedByAdmin']) {
            require 'authenticate.php';
            if (CheckTwoFactor($userEmail, md5($userEmail . $lastLogin), $lastLogin)) {
                if ($adminUser){
                    echo "<center><br><br><br><br>Welcome, $firstName, you are an admin!<br>";
                    echo '<br><a href="userqueue.php"><input name="userqueue" type="button" value="Approve/Reject User Registration Requests" class="buttons">
                    </button></a><br><br></center>';
                }
                else {
                    echo "<center><br><br><br><br>Welcome $firstName! Everything is good to go and you have full access to the site.<br><br></center>";
                }
            } else {
               header('Location: 2FA.php');
            }
        }
        else {
		echo 'Your account is currently pending approval by an admin. Please check back later to see if your account has been approved by an admin.';
        	echo '<br><br><a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="buttons"></a>';
        	exit;
        }
    } else {
	echo 'You need to confirm your email before logging in. Please check your email for the verification code/link.';
	echo '<br><br><a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="buttons"></a>';        
	exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>

<html>

<head>
    <title>Fake News Analyzer Home Page</title>
    <style>
            .buttons{
            height:30px;
        }
    </style>
</head>

<body><br><center>
    <form action="" method="post" name="frmProfile" id="frmProfile">
              <input type="search" id="searchText" name="search" placeholder="Search for an article" style="width: 400px";>
            <button>Search</button>
            <br><br>
        <a href="profile.php"><input name="userprofile" type="button" value="View/Update Profile Information" class="buttons"></a><br><br>
        <a href="logout.php"><input name="logoutbtn" type="button" value="Logout" class="buttons"></a>
    </form>
    </center>
</body>

</html>
