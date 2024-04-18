<!DOCTYPE html>
<html>

<head>
  <title>Podgl&aogon;d zdj&eogon;&cacute;</title>
  <link rel="shortcut icon" href="https://skadlitwiniwracaja.ddns.net/Pictures/icon_alfa.ico">
  <script>
    const images = <?php

    $page = $_GET["page"];
    if ($page == null) {
      echo "[]";
      goto end;
    }

    $cmd = exec("bash plikiZRozszerzeniem.sh");
    $arr = explode(",", $cmd);

    $pages = intval(count($arr) / 50) + 1;

    echo "[";

    for ($i = ((int) $page - 1) * 50; $i < (int) $page * 50 && $i < count($arr) - 1; $i++) {
      echo "'" . $arr[$i] . "',";
    }

    echo "];";

    end: ?>

    let params = undefined;
    function main() {
      params = new URLSearchParams(window.location.search);
      if (!params.has("page")) {
        params.set("page", "1");
        window.location.search = params.toString();
      }

      const pageNum = document.querySelector("#page-num");
      const text = document.createTextNode(params.get("page"));
      pageNum.appendChild(text);

      const extraInfo = document.querySelector("#extra-info");
      const maxPage = (params.get("page") - 0) * 50;
      const text2 = document.createTextNode((maxPage - 50) + "-" + maxPage);
      extraInfo.appendChild(text2);
      const container = document.querySelector("#grid-view");

      Object.entries(images).forEach(([key, val]) => {
        const item = document.createElement("a");
        item.classList = "item";
        item.href = "podgląd.php?file=" + val;
        const image = document.createElement("img");
        image.id = key;
        image.src = val + "thumbnail.jpg";

        const icon = document.createElement("img");
        icon.src = (val.endsWith(".jpg/") ? "/piotr/icons/image.svg" : "/piotr/icons/display.svg");
        icon.classList = "icon";
        item.appendChild(image);
        item.appendChild(icon);
        container.appendChild(item);
      });
    }

    function pageUp() {
      params.set("page", params.get("page") - 0 + 1);
      window.location.search = params.toString();
    }

    function pageDown() {
      params.set("page", params.get("page") - 1);
      window.location.search = params.toString();
    }
  </script>
  <style>
    img {
      max-width: 90%;
      max-height: 90%;
    }

    <?php if ($_GET["page"] == 1) {
      echo '
      .container > div:first-child { 
        visibility: hidden;
      }';
    }
    ?>

    <?php if ($_GET["page"] == $pages) {
      echo '
      .container > div:last-child { 
        visibility: hidden;
      }';
    }
    ?>

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

    .container>div:first-child>svg {
      position: fixed;
      top: calc(50vh - (75px/2));
      left: calc(5% - 0);
    }

    .container>div:last-child>svg {
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
        z-index: 2;
      }

      .arrow>svg {
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

    <div class="arrow" onclick="pageDown()">
      <!-- arrow left -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M561-240 320-481l241-241 43 43-198 198 198 198-43 43Z" />
      </svg>
    </div>

    <div id="grid-view"></div>

    <div class="arrow" onclick="pageUp()">
      <!-- arrow right -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
        <path d="M530-481 332-679l43-43 241 241-241 241-43-43 198-198Z" />
      </svg>
    </div>

  </div>

</body>

</html>