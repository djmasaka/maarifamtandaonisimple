<?php

    include 'includes/header.php';
    class Book {
        public $title;
        public $image;
        public $doc;
        function __construct($obj) {
            $this->title = $obj["title"];
            $this->image = $obj["image"];
            $this->doc = $obj["doc"];
        }
        function __toString() {
            return "title: " . $this->title . ", image: " . $this->image . ", doc: " . $this->doc;
        }
        function card() {
            return "
                <div class='card' key='{$this->title}'>
                    <img src='assets/images/{$this->image}' alt='{$this->title}' class='card-img'>
                    <div class='card-body'>
                        <h3>{$this->title}</h3>
                        <a href='assets/docs/{$this->doc}' download class='button'>Download</a>
                    </div>
                </div>
                ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/css/pico.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
    <div class="container">
        <h1>Home Page</h1>
        <div class="searchbar">
            <input type="text" id="search" name="search"/>
            <button onclick="trial()">Search</button>
        </div>
        <div class="grouping" id="cards">
            <?php
                $jsonObj = file_get_contents("assets/allbooks.json");
                $obj = json_decode($jsonObj, true);
                $books = [];
                foreach($obj as $key => $value) {
                    $example = new Book($value);
                    echo $example->card();
                }
            ?>
        </div>
    </div>
    <script type="text/javascript">
    const textBox = document.querySelector("#search");
    textBox.addEventListener("keyup", function(event) {
        if (event.target.value === "") {
            trial();
        }
        if (event.keyCode === 13) {
            event.preventDefault();
            trial();
        }
    });
    function trial() {
        const cards = document.querySelector("#cards");
        const textBox = document.querySelector("#search");
        for (let i = 0; i < cards.children.length; i++) {
            cards.children[i].style.display = "flex";
            if (!cards.children[i].innerHTML.toLowerCase().includes(textBox.value.toLowerCase())) {
                console.log(cards.children[i].getAttribute("key"));
                cards.children[i].style.display = "none";
            }
        }
    }
    </script>
</body>
</html>
