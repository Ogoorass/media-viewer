<?php
$cmd = exec("bash plikiZRozszerzeniem.sh");
$arr = explode(",", $cmd);

$image = $_GET["file"];

$i = 0;
foreach ($arr as $x) {
  if ($x == $image) {
    break;
  }
  $i++;
}

$page = intval($i / 50) + 1;
?>
<!DOCTYPE html>
<html>

<head>

  <title>Przedgl&aogon;darka zdj&eogon;&cacute;</title>
  <script type="text/javascript">
    let params = new URLSearchParams(window.location.search);
    console.log(params.toString());

    let filePath = "";


    function loadImage() {
      if (params.has("file")) {
        filePath = params.get("file");
        let fileName = filePath.replace("content/", "").replace("/", "");
        let image;

        if (fileName.endsWith(".jpg")) {
          image = document.createElement("img");
          image.id = "image-img";
          image.src = filePath + fileName;
          image.onload = function () {
            document.getElementById("loading_ico").style.display = "none";
          }

        } else if (fileName.endsWith(".mp4")) {
          image = document.createElement("video");
          image.id = "image-video";
          image.src = filePath + fileName;
          image.setAttribute("controls", "");
          image.oncanplaythrough = function () {
            document.getElementById("loading_ico").style.display = "none";
          }
        }


        document.getElementById("image").appendChild(image);

      } else {
        console.log("no file");
        przewin();
      }
    }

    function przewin(mode) {
      var xhttp = new XMLHttpRequest()

      console.log("przewin mode: " + mode);
      xhttp.onload = function () {                     //czekanie na gotowosc
        filePath = this.responseText;
        console.log("response: " + this.responseText);

        params.set("file", filePath);
        console.log("params: " + params.toString());
        window.location.search = params.toString();
      }

      var url = "przewin.php?currentFile=" + filePath + "&mode=" + mode;
      xhttp.open("GET", url, true);
      xhttp.send();

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

    .arrow>div>svg {
      width: 100px;
      aspect-ratio: 1;
      fill: #FFF;
    }

    .arrow>div>svg:hover {
      fill: #CCC;
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

      .container>div:first-child {
        position: absolute;
        bottom: -25%;
        left: calc(18% - 75px);
        width: 150px;
      }

      .container>div:last-child {
        position: absolute;
        bottom: -25%;
        right: calc(15% - 75px);
        width: 150px;
      }

      .arrow>div>svg {
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
    <div class="arrow">
      <div onclick='przewin("0")' style="cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
          <path d="M561-240 320-481l241-241 43 43-198 198 198 198-43 43Z" />
        </svg>
      </div>
    </div>

    <div id="image">
      <svg id="loading_ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path
          d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q17 0 28.5 11.5T520-840q0 17-11.5 28.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-17 11.5-28.5T840-520q17 0 28.5 11.5T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Z" />
      </svg>
    </div>


    <div id="grid-view">
      <a href="<?php echo "/piotr/?page=" . $page ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
          <path
            d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160Zm-400 0h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z" />
        </svg>
      </a>
    </div>

    <div class="arrow">
      <div onclick='przewin("1")' style="cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
          <path d="M530-481 332-679l43-43 241 241-241 241-43-43 198-198Z" />
        </svg>
      </div>
    </div>

  </div>
</body>

</html>