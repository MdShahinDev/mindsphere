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


<div class="go-to-dashboard">
      <a class="btn" style="position:absolute; top:20px; right:20px; z-index:10000; padding: 10px 30px;" href="./dashboard/DashboardResourceLibrary.php"><i style="margin-right: 10px;" class="fa-solid fa-book"></i> Go to Dashboard</a>
    </div>

<!-- ======== HERO SECTION STARTS HERE ======== -->


   
<section class="hero">
    <h1>📚 Course Library</h1>
    <p>Explore expert-led courses and tutorials to level up your skills.</p>
  </section>


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





   
     <script src="js/ResourceLibraryCourse.js"></script>
     <script src="js/script.js"></script>
</body>
</html>