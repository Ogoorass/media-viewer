<?php
$images_all = array_slice(scandir("content/"), 2); // get rid of "." and ".."
$pages = intval(count($images_all) / 50 + 1);

$page = $_GET["page"];
if ($page == null) {
  $page = 1;
}
$images_page = array_slice($images_all, ($page - 1) * 50, 50); // up to 50 images to display, based on the curent page

?>
<!DOCTYPE html>
<html>

<head>
  <title>Media overview</title>
  <link rel="shortcut icon" href="https://skadlitwiniwracaja.ddns.net/Pictures/icon_alfa.ico">
  <script>
    function main() {
      const images = <?php echo json_encode($images_page) ?>;

      const page = <?php echo $page ?>;

      const pageNum = document.querySelector("#page-num");
      const text = document.createTextNode(page);
      pageNum.appendChild(text);

      const extraInfo = document.querySelector("#extra-info");
      const maxPage = (page - 0) * 50;
      const text2 = document.createTextNode((maxPage - 50) + "-" + maxPage);
      extraInfo.appendChild(text2);
      const container = document.querySelector("#grid-view");

      Object.entries(images).forEach(([key, val]) => {
        const item = document.createElement("a");
        item.classList = "item";
        item.href = "preview.php?file=" + val;
        const image = document.createElement("img");
        image.id = key;
        image.src = "content/" + val + "/thumbnail.jpg";

        const icon = document.createElement("img");
        icon.src = (val.endsWith(".jpg") ? "/piotr/icons/image.svg" : "/piotr/icons/display.svg");
        icon.classList = "icon";
        item.appendChild(image);
        item.appendChild(icon);
        container.appendChild(item);
      });
    }

  </script>
  <style>
    img {
      max-width: 90%;
      max-height: 90%;
    }

    body {
      background-color: #212121;
    }

    .container {
      display: grid;
      width: 100%;
      height: 105%;
      grid-template-columns: 10% 79% 10%;
      gap: 0.5%;
    }

    .container>a:first-child>svg {
      position: fixed;
      top: calc(50vh - (75px/2));
      left: calc(5% - 0);
    }

    .container>a:last-child>svg {
      position: fixed;
      top: calc(50vh - (75px/2));
      right: calc(5% - 0);
    }

    .item {
      background-color: #212155;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 20px;
      aspect-ratio: 1;
      width: 100%;
      box-shadow: 0px 0px 5px 1px black;
      position: relative;
    }

    .item:hover {
      background-color: #151540;
      cursor: pointer;
    }

    .arrow {
      display: flex;
      position: relative;
      align-items: center;
      justify-content: center;
      text-align: center;
      border-radius: 50px;
      min-height: 100vh;
      width: 100%;
      height: 100%;
    }

    .arrow:hover {
      cursor: pointer;
      background-color: #181818;
    }

    .arrow>svg {
      fill: #fff;
      width: 75px;
      aspect-ratio: 1;
    }

    .icon {
      position: absolute;
      bottom: 20px;
      right: 20px;
    }

    .hidden {
      visibility: hidden;
    }

    #page-nav {
      position: fixed;
      display: flex;
      flex-direction: column;
      justify-content: center;
      top: 30px;
      left: calc(8px + 2% - 10px);
      z-index: 1;
      width: 6%;
      aspect-ratio: 1.2;
      text-align: center;
      background-color: #303030;
      border-radius: 20px;
      font-family: Arial;
      padding: 10px;
      padding-bottom: 17px;
      color: white;
    }

    #grid-view {
      display: grid;
      grid-template-columns: 19.2% 19.2% 19.2% 19.2% 19.2%;
      gap: 1%;
      row-gap: 16px;
      height: fit-content;
    }

    #page-num {
      font-size: 40px;
    }

    @media screen and (max-device-width: 500px) {
      .container {
        display: flex;
        justify-content: center;
        text-align: center;
      }

      .arrow {
        position: fixed;
        width: 75px;
        height: 75px;
        min-height: 0;
        z-index: 2;
      }

      .arrow>a>svg {
        position: static !important;
      }

      .container>div:first-child {
        top: 2vh;
        left: 5vw;
      }

      .container>div:last-child {
        top: 2vh;
        right: 5vw;
      }

      #grid-view {
        margin-top: 8vh;
        grid-template-columns: calc(100%/3 - 8px*2/3) calc(100%/3 - 8px*2/3) calc(100%/3 - 8px*2/3);
        gap: 7.5px;
      }

      #page-nav {
        position: fixed;
        top: 2.5vw;
        left: 39px;
        width: 90vw;
        aspect-ratio: 10;
      }

      #page-nav>div:nth-child(3) {
        position: absolute;
        left: 20px;
        top: 25%;
      }

      #page-nav>div:nth-child(4) {
        position: absolute;
        right: 20px;
        top: 25%;
      }
    }
  </style>
</head>

<body onload="main()">
  <div id="page-nav">
    <div id="page-num"></div>
    <div id="extra-info"></div>
  </div>

  <div class="container">

    <a class="arrow<?php if ($page == 1) {
      echo " hidden";
    } ?>" href="/piotr/?page=<?php echo $page - 1 ?>">

      <!-- arrow left -->
      <svg id="arrow_left" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M561-240 320-481l241-241 43 43-198 198 198 198-43 43Z" />
      </svg>

    </a>

    <div id="grid-view"></div>

    <a class="arrow<?php if ($page == $pages) {
      echo " hidden";
    } ?>" href="/piotr/?page=<?php echo $page + 1 ?>">

      <!-- arrow right -->
      <svg id="arrow_right" xmlns=" http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M530-481 332-679l43-43 241 241-241 241-43-43 198-198Z" />
      </svg>
    </a>


  </div>

</body>

</html>