<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$detailsMessage= "";
$passwordMessage = "";

if(isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        // Success
        $detailsMessage = "<div class='alertSuccess'>
                                Details updated successfully!
                            </div>";
    } else {
        // Failure
        $errorMessage = $account->getFirstError();

        $detailsMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
    
}

if(isset($_POST["savePasswordButton"])) {
    $account = new Account($con);


    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);


    if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        // Success
        $passwordMessage = "<div class='alertSuccess'>
                                Password updated successfully!
                            </div>";
    } else {
        // Failure
        $errorMessage = $account->getFirstError();

        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
    
}
?>

<div class="settingsContainer column">
    <div class="formSection">
        <form method="POST">
            <h2>User details</h2>
            <?php 
            $user = new User($con, $userLoggedIn);

            // If post array not exist, display data from database
            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"]: $user->getEmail();
            ?>
            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>
            <button name="saveDetailsButton">Save</button>
        </form>
    </div>

    <div class="formSection">
        <form method="POST">
            <h2>Update password</h2>
            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New Password">
            <input type="password" name="newPassword2" placeholder="Confirm password">

            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>
            <button name="savePasswordButton">Save</button>
        </form>
    </div>
</div>