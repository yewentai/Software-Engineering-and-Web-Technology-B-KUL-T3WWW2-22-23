<?php
require_once 'php/model/Feedback.php';

$new_feedback_saved = false;
if (isset($_POST['feedback'])) {
    //$text = strip_tags($_POST['feedback']);
    //$author = strip_tags($_POST['author']);
    $text =  $_POST['feedback'];
    $author = $_POST['author'];
    $feedback = new Feedback($text, $author);
    $feedback->save();
    $new_feedback_saved = is_numeric($feedback->getId());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebTech Demo</title>
    <meta charset="UTF-8" />
    <meta name="keywords" content="webtech course demo" />
    <meta name="description"
          content="This a demo for the webtech course. But still..." />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/feedback.css">
    <script defer src="js/feedback.js"></script>
    <!-- link rel="stylesheet" href="css/media_query.css" -->
</head>

<body>
<header>
    <div id="logo">
        <h1>CouBooks</h1>
        <h2>A Webtech demo site</h2>
    </div>
    <nav>
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>
</header>
<main>
    <section>
        <?php if($new_feedback_saved) { ?>
            <p>Thank you for your feedback, You can return to the <a href="main.php">main page</a> now...</p>
        <?php } else { ?>
        <h3>add feedback...</h3>
        <form action="" method="post">
            <div>
                <label for="author">Author : </label>
                <input type="text" name="author" id="author"/>
            </div>
            <div>
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback"></textarea>
            </div>
            <div>
                <button type="submit" value="Submit" id="submit">Submit</button>
            </div>
        </form>
        <?php } ?>
    </section>

</main>
<footer>
    <p>Copyright &copy 2022 WebTech. KUL&nbsp;All Rights Reserved.&nbsp;&nbsp;
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
    </p>
</footer>
</body>
</html>
