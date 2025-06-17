<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ResourceLibraryCourse.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />
    
</head>
<body>

<!-- ======== HERO SECTION STARTS HERE ======== -->


    <section class="hero">
        <?php include 'components/resourceNavbar.php' ?>

        <div class="wrapper container">
            <div class="left">
                <h2>Resource
<span class="image-border">Libaray</span> </h2>

                <p>The Resource Library in MindSphere offers users easy access to helpful materials such as articles, videos, guides, and research. These resources help users stay organized, expand knowledge, and fuel growth. This well-curated library provides easier informational articles in one organized place.</p>


                


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




      <!-- ======== FEATURE SECTION STARTS HERE ======== -->
 <section class="tabs rmv-bg">
    <button class="tab active" onclick="showCategory('personal')">Personal Development</button>
    <button class="tab" onclick="showCategory('skill')">Skill Development</button>
    <button class="tab" onclick="showCategory('study')">Study</button>
  </section>

  <section id="videoGrid" class="video-grid"></section>
  <div class="load-more-container">
    <button id="loadMoreBtn" class="btn" onclick="loadMore()">Load More</button>
  </div>

 <!-- ======== FEATURE SECTION ENDS HERE ======== -->

    <section class="footer">
        <?php include 'components/footer.php' ?>
    </section>

     <script src="js/ResourceLibraryCourse.js"></script>
     <script src="js/script.js"></script>
</body>
</html>