<?php
require_once 'php/Shop.php';

$shop = new Shop();
if (isset($_POST['submit'])) {
    $shop->processStep($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebTech Demo</title>
    <meta charset="UTF-8" />
    <meta name="keywords" content="webtech course demo" />
    <meta name="description"
          content="This a demo for the webtech course." />
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/reservation.css">
    <script defer src="js/reservation.js"></script>
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
    <?php if($shop->getStep() == 1) { ?>
    <section>
        <h3>Step 1 : Who are you</h3>
        <form action="" method="post">
            <p>Please provide some info about you, so we can search for the books you need...</p>
            <div>
                <label for="fase">Fase : </label>
                <select name="fase" id="fase">
                    <option value="1">First Bachelor</option>
                    <option value="2">Second Bachelor</option>
                    <option value="3">Third Bachelor</option>
                    <option value="4">Master</option>
                </select>
            </div>
            <div>
                <label for="email">Email : </label><input type="text" name="email" id="email"/><span id="message"></span>
            </div>
            <div>
                <button type="submit" name="submit">Next...</button>
            </div>
        </form>
    </section>
    <?php } elseif($shop->getStep() == 2) { ?>
    <section>
        <h3>Step 2 : What books do you need ?</h3>
        <form action="" method="post">
            <p>Select the books you wish to order ...</p>
            <?php foreach ($shop->getBooksPossible() as $book) {
                $bookId = $book->getId();
                $bookTitle = $book->getTitle();
                echo "<div ><input type = \"checkbox\" value=\"$bookId\" id = \"book_$bookId\" name = \"books[]\" ><label for=\"book_$bookId\">$bookTitle</label ></div>";
            } ?>
            <div><button type="submit" name="submit">Next...</button></div>
        </form>
    </section>
    <?php } elseif($shop->getStep() == 3) { ?>
    <section>
        <h3>You have ordered...</h3>
        <form action="" method="post">
             <p>Below you find an overview of the books you have reserved. Once you confirm
                your reservation you can pick them up at our KD and pay at the desk</p>
            <ul>
                <?php foreach ($shop->getBooksSelected() as $book) {
                    $bookTitle = $book->getTitle();
                    echo "<li>$bookTitle</li>";
                } ?>
            </ul>
            <div><button type="submit" name="submit">Confirm Reservation</button></div>
        </form>
    </section>
    <?php } ?>
</main>
<footer>
    <p>Copyright &copy 2022 WebTech. KUL&nbsp;All Rights Reserved.&nbsp;&nbsp;
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
    </p>
</footer>
</body>
</html>
