<?php
require_once 'php/Greeter.php';
require_once 'php/model/Feedback.php';

$greeter = new Greeter();

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
        <h2><?php echo $greeter->getGreeting() ?></h2>
        <h3>Are you ready to study ?</h3>
        <p>
            When in need for the correct course books or printed slides, you should have a
            look to our course book website for EA. Here you can find an overview of all course
            material that is needed for every course within the EA program. Select your fase and see what
            is needed...
        </p>
        <p>
            This <strong>Course Book Service</strong> site is specially designed
            as a demonstration for the web technology course.
            In the end, this page can be found on the development web
            server <a href="https://studev.groept.be/">studev.groept.be</a>
            Within this demonstration we will step-by-step create this site.
        </p>
    </section>
    <aside>
        <article>
            <h3>Opening Hours :</h3>
            <ul>
                <li>Mon: 9am-11am</li>
                <li>Tue: 1pm-4pm</li>
                <li>Fri: 1pm-4pm</li>
            </ul>
        </article>
        <article>
            <h3>Feedback</h3>
            <?php
            foreach ( Feedback::getAllFeedback() as $item) {
                $text = $item->getText();
                $author = $item->getAuthor();
                $created = $item->getCreated()->format("d/m");
                // only single variables are allowed between " "
                echo "<p>$created : $text <em>($author)</em></p>\n";
            }
            ?>
                <!-- Funny -->
<!--
                <style>
                /* https://css-tricks.com/pac-man-in-css/ */
                .pacman {
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    background: #F2D648;
                    position: absolute;
                    left: 40%;
                    top: 30%;
                    margin-top: 20px;
                }

                .pacman__eye {
                    position: absolute;
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    top: 40px;
                    right: 80px;
                    background: #333333;
                }

                .pacman__mouth {
                    background: #FFF;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    clip-path: polygon(100% 74%, 44% 48%, 100% 21%);
                    animation-name: eat;
                    animation-duration: 0.7s;
                    animation-iteration-count: infinite;
                }

                @keyframes eat {
                    0% {
                        clip-path: polygon(100% 74%, 44% 48%, 100% 21%);
                    }
                    25% {
                        clip-path: polygon(100% 60%, 44% 48%, 100% 40%);
                    }
                    50% {
                        clip-path: polygon(100% 50%, 44% 48%, 100% 50%);
                    }
                    75% {
                        clip-path: polygon(100% 59%, 44% 48%, 100% 35%);
                    }
                    100% {
                        clip-path: polygon(100% 74%, 44% 48%, 100% 21%);
                    }
                }
                </style>
                <div class="pacman">
                    <div class="pacman__eye"></div>
                    <div class="pacman__mouth"></div>
                </div>
-->

                <!-- Scary -->
<!--
                <script>
                    let links = document.getElementsByTagName('a');
                    for (let link of links) {
                        if(link.text.toLowerCase() === "order") {
                            link.href = "https://www.bol.com"
                        }
                    }
                </script>
-->
            <a href="feedback.php">Add feedback...</a>
        </article>
    </aside>
</main>
<footer>
    <p>Copyright &copy 2022 WebTech. KUL&nbsp;All Rights Reserved.&nbsp;&nbsp;
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
    </p>
</footer>
</body>
</html>
