<?php
//Lab 4 - Extending the work of lab to add functions and arrays in my source code.
//Validation of the form input using PHP instead of Javascript.
define("noLinks", 5);
$href = array("home.php", "about.php", "sitemap.php", "contact.php", "account.php");
$links = array("Home", "About", "Site Map", "Contact Us", "My Account");

//creating a two dimension array for these two closely related arrays.
$navLinks = array($href, $links);

//variable initialization used to store values submitted in form.
$name = $email = $tel = $title = $time = $thanks = $welcomeMsg = "";

//array for the drop down list of titles.
$titleList = array("Mr.", "Mrs.", "Ms.");

//array for the time selection radio buttons.
$timeList = array("morning", "afternoon", "evening");

$allValid = true;

//declaring the functions.
function display_navigation() {
    global $navLinks;
    for ($x=0; $x<noLinks; $x++) {
        echo "<li><a href=\"" . $navLinks[0][$x] . "\">" . $navLinks[1][$x] . "</a></li>";
    }
}

function validate_name($name) {

    if ($name == "") {
        $message = "Enter your name";
		$allValid = false;
    } else if (!preg_match ("/^[a-zA-z ]*$/", $name) ) {
        $message = "Enter valid name. Only letters and space are allowed.";
		$allValid = false;
    } else {
        $message = "Valid Name";
    }

    return $message;
}

function validate_email($email) {

    if ($email == "") {
        $message = "Enter email";
		$allValid = false;
    } else if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $message = "Enter valid email address, e.g. emailid@domain.com";
		$allValid = false;
    }
    else {
        $message = "Valid Email";
    }

    return $message;
}

function validate_tel($tel) {

    if ($tel == "") {
        $message = "Enter your contact number";
		$allValid = false;
    } else if (!preg_match ("/^[0-9() ]*$/", $tel) ) {
        $message = "Enter valid number. Only numbers, brackets and space are allowed, e.g. (111) 222 3333.";
		$allValid = false;
    }
    else {
        $message = "Valid Telephone";
    }

    return $message;
}

function validate_title($title) {

    if ($title == "") {
        $message = "Select your title.";
		$allValid = false;
    }
    else {
        $message = "Valid title selected.";
    }
    return $message;
}


function validate_time($time) {
    if ($time == "") {
        $message = "Select the time you would like to be contacted.";
		$allValid = false;
    }
    else {
        $message = "Valid time checked.";
    }
    return $message;
}


if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $title = $_POST['title'];
    $time = !isset($_POST['time']) ? "" : $_POST['time'];

    $nameErr = validate_name($name);
    $emailErr = validate_email($email);
    $telErr = validate_tel($tel);
    $titleErr =validate_title($title);
    $timeErr = validate_time($time);
	
	//Welcome message.
	if ($allValid==true) {

        $welcomeMsg = "Thank you " . $title . " " . $name . ", for contacting us. We will get back to you as soon as possible ";
        $welcomeMsg .= "on your contact number  " . $tel . " in the " . $time . " hours.";

    }

}


?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lab 3, HTTP5202 - Form Validation using HTML, Javascript</title>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>

<body>

<!-- HEADER
    Icon taken from www.flaticon.com-->
<header>
    <img src="images/programmer.png" id="icon">
    <h2 id="header-title">J. Qureshi, Hamilton, Canada.</h2>

    <nav class="menu" id="main-menu">
        <ul >
            <?php
            display_navigation();
            ?>
        </ul>
    </nav>
</header>

<main>

    <!--FORM -->
    <form action="#" method="post" id="contactUs" name="formContact">
        <fieldset >
            <legend>Contact Us</legend>

            <!-- Welcome Msg whenever the user successfully submits a request -->
            <p style="color:green;">
                <?= isset($welcomeMsg)? $welcomeMsg: ''; ?>
            </p>

            <div id="activeform">

                <!-- Title and Name -->
                <p><label for="in_Name">Your Name:</label>
                    <select name="title">
                        <!--Drop down menu option list created using arrays -->
                        <option value=""></option>
                        <option value="<?= $titleList[0] ?>" <?= ($title == $titleList[0]) ? 'selected' : ''; ?>  > <?= $titleList[0] ?> </option>
                        <option value="<?= $titleList[1] ?>" <?= ($title == $titleList[1]) ? 'selected' : ''; ?>  > <?= $titleList[1] ?> </option>
                        <option value="<?= $titleList[2] ?>" <?= ($title == $titleList[2]) ? 'selected' : ''; ?>  > <?= $titleList[2] ?> </option>
                    </select>
                    <input type="text" id="in_Name" name="name"/ value=<?= isset($name) ? $name : ''; ?>>
                    <span id="NameError" class="error"><?= isset($titleErr)? $titleErr: ''; ?></span>
                    <span id="NameError" class="error"><?= isset($nameErr)? $nameErr: ''; ?></span>
                </p>

                <!-- Email -->
                <p><label for="in_Email">Email Address:</label>
                    <input type="text" id="in_Email" name="email"/ value=<?= isset($email) ? $email : ''; ?>>
                    <span id="EmailError" class="error"><?= isset($emailErr)? $emailErr: ''; ?></span>
                </p>

                <!-- Telephone -->
                <p><label for="in_Tel">Telephone Number:</label>
                    <input type="text" id="in_Tel" name="tel"/ value=<?= isset($tel) ? $tel : ''; ?>>
                    <span id="TelError" class="error"><?= isset($telErr)? $telErr: ''; ?></span>
                </p>

                <!-- Radio Checkbox for time to contact created using arrays-->
                <p>What is the best time to call you back:
                    <span id="TelError" class="error"><?= isset($timeErr)? $timeErr: ''; ?></span>
                </p>
                <input type="radio" id="<?= $timeList[0] ?>" name="time" value="<?= $timeList[0] ?>"
                    <?= ($time == $timeList[0]) ? 'checked' : ''; ?> >
                <label for="<?= $timeList[0] ?>"><?= ucfirst($timeList[0]) ?></label><br>

                <input type="radio" id="<?= $timeList[1] ?>" name="time" value="<?= $timeList[1] ?>"
                    <?= ($time == $timeList[1]) ? 'checked' : ''; ?> >
                <label for="<?= $timeList[1] ?>"><?= ucfirst($timeList[1]) ?></label><br>

                <input type="radio" id="<?= $timeList[2] ?>" name="time" value="<?= $timeList[2] ?>"
                    <?= ($time == $timeList[2]) ? 'checked' : ''; ?> >
                <label for="<?= $timeList[2] ?>"><?= ucfirst($timeList[2]) ?></label><br>

                <!-- SUBMIT -->
                <p id="listSubmit">
                    <input type="submit" value="Submit" name="submit" id="button">
                </p>
            </div>

        </fieldset>
    </form>

</main>

<footer>
    <p>&copy; Hamilton, Canada. All rights reserved.</p>
    <nav class="menu" id="footer-id">
        <ul >
            <?php
            display_navigation();
            ?>
        </ul>
    </nav>

</footer>

</body>
</html>
