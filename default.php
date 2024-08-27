<?php
    require 'PhpMailer/phpMailer.php';
    require 'PhpMailer/Exception.php';
    require 'PhpMailer/Smtp.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
        


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msgSubmit'])) {
    
    //Your server-side secret key from reCAPTCHA settings
    $recaptcha_secret = '6LcbRi4qAAAAAN-bCefS8x23twwsSJ4av7SM2kH_';

    // The response from the user's interaction with the CAPTCHA
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Making a request to Google's reCAPTCHA API to verify the user's response
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");

    // Decoding the JSON response from Google into an associative array
    $response_keys = json_decode($response, true);

    // Checking if the response from Google reCAPTCHA was successful
    if (intval($response_keys["success"]) !== 1) {
        header('Location: default.php?msg=Please complete the CAPTCHA!'); // The CAPTCHA failed, inform the user
    }
    else
    {
    $mail = new PHPMailer(true);
    if (isset($_POST['email'])) 
    {
        $username = 'skcomputercenter80@gmail.com';
        try {
            //$mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'connectmypc3@gmail.com';
            $mail->Password   = 'zzhu unml jbpc wfdu'; // Use App Password or correct credentials
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($_POST['email'], $_POST['sender_name']);
            $mail->addAddress($username);
            $mail->addReplyTo($_POST['email'], 'Information');

            $mail->isHTML(false);
            $mail->Subject = $_POST['subject'];
            $mail->Body    = $_POST['message'];

            $mail->send();
            
            header('Location: default.php?msg=Sent Successfully!');
        } catch (Exception $e) {
            header('Location: default.php?msg={$mail->ErrorInfo}');
        }
    }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe']))
{
    $email = $_POST['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $file = 'subscribers.json';

        // Read the existing subscribers from the file
        $subscribers = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        // Check if the email exists in the subscribers array
        $emailExists = false;
        foreach ($subscribers as $subscriber) {
            if (isset($subscriber['email']) && $subscriber['email'] === $email) {
                $emailExists = true;
                break;
            }
        } 
        if(!$emailExists) {
        
            // Add the new subscriber
            $subscribers[] = ['email' => $email];

            // Save the updated list back to the file
            if (file_put_contents($file, json_encode($subscribers, JSON_PRETTY_PRINT))) {
                header('Location: default.php?msg=Subscribed Successfully!');

                // echo "Thank you for subscribing!";
            } else {
                header('Location: default.php?msg=There was an error saving your subscription. Please try again!');
            }
        }
        else{
            header('Location: default.php?msg=Already Subscribed!');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Computer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="nav_style.css">
    <link rel="stylesheet" href="course_style.css">
    <link rel="stylesheet" href="gallery_style.css" />
    <link rel="stylesheet" href="contact_style.css">
    <link rel="stylesheet" href="footer_style.css">
    <link rel="stylesheet" href="team_style.css">
    <link rel="stylesheet" href="alert.css">
    <link rel="stylesheet" href="bottom_icon.css">
    <link rel="icon" href="Image/Logo/titlelogo.jpg">
</head>

<body>
    <!-- -----Navigation Bar------ -->
    <header id="header">
        <nav class="nav">
            <div class="logo">
                <img src="Image/Logo/titlelogo.jpg" alt="">
            </div>
            <div class="menues">
                <ul id="ulMenu">
                    <li><a href="#header">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="#course-section">Course</a></li>
                    <li><a href="#team-section">Instructor</a></li>
                    <LI><a href="#contact-section">Contact Us</a></LI>
                    <i class="fas fa-times" onclick="hideMenu()"></i>
                </ul>
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </div>
        </nav>
        <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['msg'])) {
                echo"<div class='alert'>
                        <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span> 
                        <strong>{$_GET['msg']}</strong>
                    </div>";
            }
        ?>
    </header>
    <main>
        <!-- -----Home Section------ -->
        <section id="home">
            <div class="home">
                <div class="wrapper">
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>

                    <div class="home-content">
                        <div class="home-heading">
                            <div class="heading-content">
                                <h2 class="tagline">Your Partner in Technical Growth..</h2>
                                <h1 class="title">SK COMPUTER <div class="new-line"></div>
                                    <span class="auto-change"></span>
                                </h1>
                            </div>
                        </div>
                        <div class="right-section">
                            <img src="./Image/home-bg.jpg" check="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ----- Course section ----- -->
        <section id="course-section">
            <h1 class="heading">Course Offered</h1>
            <div class="course-container">
                <!-- <div class="three-month courses">
                <h1 class="course-subheading">Basic Course</h1>
                <div class="three-month-image">

                </div>
                <div class="course-content">
                    <h2>Duration - 3 Months</h2>
                </div>
            </div>
            <div class="six-month courses">
                <h1 class="course-subheading">Advance Basic Course</h1>
                <div class="six-month-image">

                </div>
                <div class="course-content">
                    <h2>Duration - 6 Months</h2>
                </div>
            </div> -->
                <div class="course-wrapper">
                    <ol>
                        <li>
                            <h3 class="changeColor">Basic Course </h3>
                            <pre class="changeColor">[ Duration: 3 Months ]</pre>
                        </li>
                        <li>
                            <h3 class="changeColor">Advance Basic Course</h3>
                            <pre class="changeColor">[ Duration: 6 Months ]</pre>
                        </li>
                        <li>
                            <h3 class="changeColor">Graphic Designing</h3>
                            <pre class="changeColor">[ Duration: 3 Months ]</pre>
                        </li>
                    </ol>
                </div>
                <div class="course-wrapper">
                    <ol start="4">
                        <li>
                            <h3 class="changeColor">Web Designing</h3>
                            <pre class="changeColor">[ Duration: 3 Months ]</pre>
                        </li>
                        <li>
                            <h3 class="changeColor">Programming Language</h3>
                            <pre class="changeColor">[ Duration: 3 Months ]</pre>
                        </li>
                        <li>
                            <h3 class="changeColor">PC Troubleshooting</h3>
                            <pre class="changeColor">[ Duration: 1 Months ]</pre>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- -----Team Section----- -->
        <section id="team-section">
            <h1 class="heading">Instructor</h1>
            <div class="team-container">
                <div class="team-content">
                    <div class="team-image-1">

                    </div>
                    <div class="team-text-content">
                        <h2 class="name team-content-color">Sushil Kumar Singh</h2>
                        <h3 class="qualification team-content-color">MCA</h3>
                        <h3 class="experience team-content-color">8 Years of Experiences</h3>
                        <span class="team-content-color"><a href="https://sushilkumarsingh.com.np/" target="_main">Show
                                Profile</a></span>
                    </div>
                </div>
                <div class="team-content">
                    <div class="team-image-2">

                    </div>
                    <div class="team-text-content">
                        <h2 class="name team-content-color">Sanjay Kumar Das</h2>
                        <h3 class="qualification team-content-color">B-Tech. Pursuing</h3>
                        <h3 class="experience team-content-color">2 Years of Experiences</h3>
                        <span class="team-content-color"><a href="https://sanjaydas.com.np/" target="_main">Show
                                Profile</a></span>
                    </div>
                </div>
                <div class="team-content">
                    <div class="team-image-3">

                    </div>
                    <div class="team-text-content">
                        <h2 class="name team-content-color">Sumit Kumar Yadav</h2>
                        <h3 class="qualification team-content-color">B-Tech. Pursuing</h3>
                        <h3 class="experience team-content-color">2 Years of Experiences</h3>
                        <span class="team-content-color"><a href="https://sumityadav56262.github.io/portfolio"
                                target="_main">Show
                                Profile</a></span>
                    </div>
                </div>
            </div>

        </section>
        <!-- Gallery section -->
        <section id="gallery-section">
            <h1 class="heading">Photos Gallery</h1>
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img
                            src="Image/Gallery/lab_practice_1.jpg" />
                    </div>
                    <div class="swiper-slide">
                        <img
                            src="Image/Gallery/collage_group.jpg" />
                    </div>
                    <div class="swiper-slide">
                        <img
                            src="Image/Gallery/lab_practice_2.jpg"/>
                    </div>
                    <div class="swiper-slide">
                        <img src="Image/Gallery/1.jpg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="Image/Gallery/2.jpg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="Image/Gallery/3.jpg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="Image/Gallery/4.jpg" />
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <!-- -----Contact Section----- -->
        <section id="contact-section">
            <h1 class="heading">Contact Us</h1>
            <div class="contact-container">
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3556.200890637715!2d85.6018475865777!3d26.96053689776093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ec7df012981c8d%3A0x86822ed272408f2c!2sSK%20Computer%20Training%20Center%2CBabarganj!5e0!3m2!1sen!2snp!4v1724154636560!5m2!1sen!2snp"
                        width="100%" height="90%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="contact-form-container">
                    <div class="contact-right">
                        <form action="" id="msg_form" method="post">
                            <input type="text" name="sender_name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <input type="text" name="subject" placeholder="Subject" required>
                            <textarea name="message" rows="6" placeholder="Your Message" id=""></textarea>
                            <div id="html_element"></div>
                            <br />
                            <input type="submit" class="btn" name="msgSubmit" id="submitBtn" value="Submit" disabled />
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

     <!-- Bottom Icons -->
     <div class="bottom-icons">
      <a href="tel:+9779749948585" class="call">
        <i class="fa fa-phone"></i>
      </a>
      <a href="https://wa.me/+9779749948585" class="whatsapp" target="_blank">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
    </div>

    <!-- -----Footer Section----- -->
    <footer class="footer" id="footer">
        <div class="footer-row">
            <div class="footer-col">
                <h4>Info</h4>
                <ul class="links">
                    <li><a href="#header">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="#contact-section">Contact Us</a></li>
                    <li><a href="#course-section">Course</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact info</h4>
                <ul class="links">
                    <li><a href="#footer"><i class="fa-solid fa-location-dot"></i><span> &nbsp;Chandranagar-2, Sarlahi,
                                Nepal</span></a></li>
                    <li><a href="#footer"><i class="fa-solid fa-envelope"></i><span>
                                &nbsp;Skcomputercenter80@gmail.com</span></a>
                    </li>
                    <li><a href="tel:+977-9749948585"><i class="fa-solid fa-phone"></i><span>
                                &nbsp;+977-9749948585</span></a></li>
                    <li><a href="tel:+977-9810225991"><span>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;+977-9810225991</span></a>
                    </li>
                    <li><a href="tel:+977-9866113841"><span>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;+977-9866113841</span></a>
                    </li>
                </ul>
            </div>
            <div class="footer-col subscribe-section">
                <h4>Newsletter</h4>
                <p>
                    Subscribe to our newsletter and never miss out on our latest news and exclusive offers.
                </p>

                <form action='' id="subscribe_form" method="post">
                    <input type="email" placeholder="Your email" name="email" required>
                    <button class="" name="subscribe" type="submit">SUBSCRIBE</button>
                </form>
                <div class="icons">
                    <a href="https://www.facebook.com/skcompcenter" target="_blank"><i
                            class="fa-brands fa-facebook"></i></a>
                    <a href="#footer" target="_blank" hidden><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://www.youtube.com/@MRSKSIR" target="main"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#footer" target="_blank" hidden><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        <div class="dev">
            <div class="footer-border"> Copyright © 2024. SK Computer Training Center, All right reserved <i
                    class="fa-solid fa-heart"></i> with
                <a href="https://bwcdigital.com" target="_blank">Blue Waves Pvt. Ltd.</a>
            </div>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/b9c282043e.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

    <script>
    var typed = new Typed('.auto-change', {
        strings: ['COACHING CENTER', 'INSTITUTE CENTER', 'TRAINING CENTER'],
        typeSpeed: 100,
        backSpeed: 100,
        loop: true,
    });
    </script>

    <script>
    var slideMenu = document.getElementById("ulMenu");

    function showMenu() {
        slideMenu.style.right = "0px";
    }

    function hideMenu() {
        slideMenu.style.right = "-150px";
    }
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        autoplay: {
            delay: 1700,
            disableOnInteraction: false,
        },
        grabCursor: true,
        centeredSlides: true,
        loop: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });
    </script>
    <!-- ------------captch----------- -->
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>
    <script src="captcha.js"></script>

    <!-- ------------alert box----------- -->
    <script>
    function hideElementAfterDelay(elementId, delay) {
        setTimeout(function() {
            document.querySelector(elementId).style.display = 'none';
        }, delay);
    }

    // Call the function to hide the alert after 3 seconds
    hideElementAfterDelay('.alert', 3000); // 3000 milliseconds = 3 seconds
    </script>
</body>


</html>