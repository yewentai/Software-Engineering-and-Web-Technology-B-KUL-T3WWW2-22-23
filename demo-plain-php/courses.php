<?php
require_once 'php/model/Course.php';
require_once 'php/model/Book.php';
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
    <link href="css/courses.css" rel="stylesheet" type="text/css"/>
    <script defer src="js/courses.js"></script>
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
        <p>Below you can find an overview of all available courses.</p>
        <ul>
            <?php
            foreach (Course::getAllCourses() as $course) {
                $courseName = $course->getName();
                echo "<li>$courseName <ul>";
                foreach (Book::getBooksByCourseId($course->getId()) as $book) {
                    $bookTitle = $book->getTitle();
                    $bookIsbn = $book->getIsbn();
                    echo "<li class=\"bookItem\" data-isbn=\"$bookIsbn\">$bookTitle</li>";
                }
                echo "</ul></li>";
            }
            ?>
        </ul>
        <p id="info-block">Extra info : <em id="info-text">click a book title for extra info</em></p>
    </section>
</main>
<footer>
    <p>Copyright &copy 2022 WebTech. KUL&nbsp;All Rights Reserved.&nbsp;&nbsp;
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
    </p>
</footer>
</body>
</html>
