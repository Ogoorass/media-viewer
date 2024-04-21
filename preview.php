<?php
$images = array_slice(scandir("content/"), 2); // get rid of "." and ".."
$image = $_GET["file"];

if ($image == null) {
  $image = $images[0];
  $key = 0;
} else {
  $key = array_search($image, $images);
  if ($key === false) {
    http_response_code(400);
    exit();
  }
}


$page = intval(($key + 1) / 50) + 1;

if ($key > 0) {
  $previous_image = $images[$key - 1];
}

if ($key + 1 < count($images)) {
  $next_image = $images[$key + 1];
}

?>
<!DOCTYPE html>
<html>

<head>

  <title>Media preview</title>
  <link rel="shortcut icon" href="https://skadlitwiniwracaja.ddns.net/Pictures/icon_alfa.ico">

  <script type="text/javascript">

    function loadImage() {

      const fileName = "<?php echo $image ?>";
      const filePath = "content/" + fileName + "/" + fileName;
      let image;
      if (fileName.endsWith(".jpg")) {
        image = document.createElement("img");
        image.id = "image-img";
        image.src = filePath;
        image.onload = function () {
          document.getElementById("loading_ico").style.display = "none";
        }
      } else if (fileName.endsWith(".mp4")) {
        image = document.createElement("video");
        image.id = "image-video";
        image.src = filePath;
        image.setAttribute("controls", "");
        image.oncanplaythrough = function () {
          document.getElementById("loading_ico").style.display = "none";
        }
      }

      document.getElementById("image").appendChild(image);
    }

  </script>

  <style>
    body {
      background-color: #212121;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
      text-align: center;
    }

    .container {
      height: 100vh;
      width: 100%;
      display: grid;
      grid-template-columns: 10% 75% 10%;
      gap: 2.5%;
      padding: 0;
      margin: 0;
    }

    .arrow {
      width: 100%;
      place-self: center;
      justify-content: center;
      display: flex;
      margin: 0;
      padding: 0;
    }

    #image {
      place-self: center;
      display: flex;
      justify-content: center;
      text-align: center;
    }

    #loading_ico {
      position: fixed;
      top: calc(50vh - 50px);
      left: calc(50vw - 50px);
      width: 100px;
      aspect-ratio: 1;
      fill: #616195;
      animation: spin 2s infinite linear;
    }

    #image-img,
    #image-video {
      max-height: 90vh;
      max-width: 100%;
      box-shadow: rgba(100, 100, 100, 1) 0px 22px 70px 4px;
      border-radius: 50px;
    }

    .arrow>svg {
      width: 100px;
      aspect-ratio: 1;
      fill: #FFF;
    }

    .arrow>svg:hover {
      fill: #CCC;
    }

    .hidden {
      visibility: hidden;
    }

    #input-image-name {
      width: 200px;
      background-color: #888888;
      margin: 10px;
      border-color: #aaaaaa;
      border-radius: 4px
    }

    #input-go {
      background-color: #888888;
      border-radius: 4px;
    }

    #input-go:hover {
      background-color: #555555;
      cursor: pointer;
    }

    #input-image-name:hover {
      background-color: #555555;
    }

    #input-image-name:focus {
      border: solid 2px #dddddd;
      outline: none;
    }

    #grid-view {
      position: absolute;
      top: 30px;
      right: 40px;
      color: white;
    }

    #grid-view:hover {
      cursor: pointer;
      color: #dddddd;
    }

    #grid-view>a>svg {
      width: 50px;
      aspect-ratio: 1;
      fill: #FFF;
    }

    #grid-view>a>svg:hover {
      fill: #CCC;
    }

    #grid-view>a {
      color: #FFF;
      text-decoration: none;
    }

    @media screen and (max-device-width: 500px) {
      body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }

      .container {
        position: relative;
        display: flex;
        justify-content: center;
        text-align: center;
        margin: 0;
        margin-top: 6vw;
        height: 67vh;
      }

      .container>a:first-child {
        position: absolute;
        bottom: -25%;
        left: calc(18% - 75px);
        width: 150px;
      }

      .container>a:last-child {
        position: absolute;
        bottom: -25%;
        right: calc(15% - 75px);
        width: 150px;
      }

      .arrow>svg {
        width: 150px;
      }

      #image {
        display: flex;
      }

      #loading_ico {
        top: 34vh;
      }

      #image-img,
      #image-video {
        max-width: 90vw;
        max-height: 67vh;
        box-shadow: rgba(100, 100, 100, 1) 0px 22px 70px 4px;
        border-radius: 50px;
      }

      #grid-view {
        position: absolute;
        top: auto;
        bottom: -25%;
        left: calc(50% - 75px);
        width: 150px;
        height: 150px;
      }

      #grid-view>a>svg {
        width: 150px;
      }
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body onload="loadImage()">
  <div class="container">
    <a class="arrow<?php if ($previous_image == null) {
      echo " hidden";
    } ?>" href="/piotr/preview.php?file=<?php echo $previous_image; ?>">

      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M561-240 320-481l241-241 43 43-198 198 198 198-43 43Z" />
      </svg>


    </a>

    <div id="image">
      <svg id="loading_ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path
          d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
      </svg>
    </div>


    <div id="grid-view">
      <a href="/piotr/?page=<?php echo $page; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
          <path
            d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160Zm-400 0h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z" />
        </svg>
      </a>
    </div>

    <a class="arrow<?php if ($next_image == null) {
      echo " hidden";
    } ?>" href="/piotr/preview.php?file=<?php echo $next_image; ?>">

      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M530-481 332-679l43-43 241 241-241 241-43-43 198-198Z" />
      </svg>

    </a>

  </div>
</body>

</html>