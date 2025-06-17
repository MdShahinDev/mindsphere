<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindSphere</title>

    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- ======== HERO SECTION STARTS HERE ======== -->


    <section class="hero">
        <?php include 'components/navBar.php' ?>

        <div class="wrapper container">
            <div class="left">
                <h2>Think Clear, <br>
                    Stay Focused, <br>
                    Achieve <span class="image-border">More</span> </h2>

                <p>MindSphere is a self-help platform that supports personal growth and better time management. It helps users track their productivity, manage tasks, build habits, stay focused, and stay motivated. The goal is to make life more organized and balanced by offering helpful tools in one place.</p>


                <a href="signup.php">Get Started</a>


            </div>

            <div class="right">

                <div class="background-div">
                    <img class="floating-icons icon-1" src="img/hero/Calendar.png" alt="">
                    <img class="floating-icons icon-2" src="img/hero/clock-2.png" alt="">
                    <img class="floating-icons icon-3" src="img/hero/goal.png" alt="">
                    <img class="floating-icons icon-4" src="img/hero/Check-box.png" alt="">
                    <img class="floating-icons icon-5" src="img/hero/clock.png" alt="">


                </div>

                <div class="character-1">
                    <img src="img/hero/Only-character.png" alt="">
                </div>
            </div>
        </div>
    </section>


    <!-- ======== HERO SECTION ENDS HERE ======== -->


    <!-- ======== SERVICE SECTION STARTS HERE ======== -->
    <section class="services" id="services">
        <div class="container">
            <div class="service-cards">
                <div class="service-card">
                    <div class="service-icon chat-icon"></div>
                    <h3>Live Chat</h3>
                    <p>Connect instantly with experts or peers to ask questions and get real-time help.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon exam-icon"></div>
                    <h3>Examination</h3>
                    <p>Test your knowledge with structured quizzes and assessments.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon medal-icon"></div>
                    <h3>Competition</h3>
                    <p>Participate in challenges to compete, learn, and earn rewards.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ======== SERVICE SECTION ENDS HERE ======== -->





    <!-- ======== FEATURE SECTION STARTS HERE ======== -->
    <section class="features">
        <div class="container">
            <h2>Top Features</h2>
            <div class="features-carousel">
                <div class="carousel-container">
                    <div class="feature-cards" id="featureCards">
                        <div class="feature-card">
                            <div class="feature-image productivity-img">

                                <img src="img/productivity-tracker.png" alt="">
                            </div>
                            <h3>Productivity Tracker</h3>
                            <button class="enroll-btn">Enroll Now</button>
                        </div>
                        <div class="feature-card">
                            <div class="feature-image resource-img">
                                <img src="img/resourse-library.png" alt="">
                            </div>
                            <h3>Resource Library</h3>
                            <button class="enroll-btn">Enroll Now</button>
                        </div>
                        <div class="feature-card">
                            <div class="feature-image analytics-img">
                                <img src="img/analytical-dashboard.png" alt="">
                            </div>
                            <h3>Analytical Dashboard</h3>
                            <button class="enroll-btn">Enroll Now</button>
                        </div>
                        <div class="feature-card">
                            <div class="feature-image ai-img">
                                <img src="img/ai-assistant.png" alt="">
                            </div>
                            <h3>AI Assistant</h3>
                            <button class="enroll-btn">Enroll Now</button>
                        </div>
                        <div class="feature-card">
                            <div class="feature-image habit-img">
                                <img src="img/productivity-tracker.png" alt="">
                            </div>
                            <h3>Habit Tracker</h3>
                            <button class="enroll-btn">Enroll Now</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-controls">
                    <button class="prev-btn" id="prevBtn">‹</button>
                    <button class="next-btn" id="nextBtn">›</button>
                </div>
                <div class="carousel-dots" id="carouselDots">
                    <span class="dot active" data-slide="0"></span>
                    <span class="dot" data-slide="1"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ======== FEATURE SECTION ENDS HERE ======== -->

    <section class="footer">
        <?php include 'components/footer.php' ?>
    </section>

    <script src="js/script.js"></script>
</body>

</html>