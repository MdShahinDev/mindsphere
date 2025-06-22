<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ResourceLibraryPodcast.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />
    
</head>
<body>




<section class="hero">
    <h1>🎧 Podcast Library</h1>
    <p>Explore motivational talks, interviews, and knowledge-sharing audio content.</p>
  </section>

  <div class="tabs">
    <button class="tab active" onclick="showCategory('mindset')">Mindset</button>
    <button class="tab" onclick="showCategory('tech')">Tech</button>
    <button class="tab" onclick="showCategory('interviews')">Interviews</button>
  </div>

  <div class="podcast-grid" id="podcastGrid"></div>
  <button id="loadMoreBtn" onclick="loadMore()">Load More</button>


     <script src="js/ResourceLibraryPodcast.js"></script>
     <script src="js/script.js"></script>
</body>
</html>