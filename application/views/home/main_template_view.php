<!doctype html>
<head>
    <meta charset="utf-8">
    <title><?php echo $this->title ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<header>
    <div class="row">
        <?php echo $this->menu; ?>
        <?php
        if (isset($this->log_window)) {
            echo $this->log_window->render();
        }
        ?>
    </div>

</header>

<section>
    <?php
    if (isset($this->body)) {
        echo $this->body->render();
    }
    ?>
</section>

<footer>
    <?php
    if (isset($this->footer)) {
        echo $this->footer->render();
    }
    ?>
</footer>

<!--BOOTSTRAP-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<!-------------->
</body>
</html>