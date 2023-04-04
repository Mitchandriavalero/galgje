<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galgje</title>
    <link rel="stylesheet" href="galgje.css">
    <script src="galgje.js" defer></script>
</head>

<body>
    <h1>Welkom bij Galgje</h1>
    <?php
    session_start();

    if (isset($_POST['reset'])) {
        session_destroy();
        header("location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    $wordarry = array("peppernuts", "strawberry", "pancakes");

    if (!isset($_SESSION['word'])) {
        $rand = rand(0, count($wordarry) - 1);
        $word = $wordarry[$rand];
        $_SESSION["word"] = strtoupper(trim($word));
    }

    $form = true;
    if (isset($_POST['submit']) && isset($_POST['checkbox'])) {
        if (stripos($_SESSION['word'], $_POST['checkbox'][0]) === false) {
            array_push($_SESSION['wrong_letters'], $_POST['checkbox'][0]);
        } else {
            array_push($_SESSION['correct_letters'], $_POST['checkbox'][0]);
        }
    }

    if (!isset($_SESSION['wrong_letters'])) {
        $_SESSION['wrong_letters'] = array();
    }
    if (!isset($_SESSION['correct_letters'])) {
        $_SESSION['correct_letters'] = array();
    }

    $show = '';
    for ($i = 0; $i < strlen($_SESSION['word']); $i++) {
        $show .= in_array(substr($_SESSION['word'], $i, 1), $_SESSION['correct_letters']) ? substr($_SESSION['word'], $i, 1) : "*";
    }

    echo $show;

    if (count($_SESSION['wrong_letters']) >= 9) {
        echo '<h1 class="visible"></h1><h1 class="invisible"></h1> The word was ' . $_SESSION['word'] . '<br /The game will restart in 10 seconds.';
        $form = false;
        session_destroy();
        header("Refresh: 10; URL=" . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($show == $_SESSION['word'] && $form == true) {
        echo '<h1 style="text-decoration:blink">! Congratulations !</h1>The game will restart in 10 seconds.';
        $form = false;
        session_destroy();
        header("Refresh: 10; URL=" . $_SERVER['REQUEST_URI']);
        exit;
    }
    ?>

    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <?php
        if ($form == true) {
            $letters = range("A", "Z");
            foreach ($letters as $letter) {
                if (!in_array($letter, $_SESSION['correct_letters']) && !in_array($letter, $_SESSION['wrong_letters'])) {
        ?>
                    <label for="<?php echo $letter ?>"><?php echo $letter ?></label><input name="checkbox[]" id="<?php echo $letter ?>" type="checkbox" value="<?php echo $letter ?>" />
            <?php
                }
            }
            ?> <br>
            <input class="button" name="submit" type="submit" value="submit" />
        <?php
        }
        ?>
        <input class="button" name="reset" type="submit" value="reset" />
    </form>
<div class="man">
    <?php
    $f[9] = '
    ________
    |/    |
    |     0
    |    /|\
    |    / \
    |
    |__
';
    $f[8] = '
    ________
    |/    |
    |     0
    |    /|\
    | 
    |
    |__
';
    $f[7] = '
    ________
    |/    |
    |     0
    | 
    |
    |
    |__
';
    $f[6] = '
    _______
    |/    |
    | 
    |
    |
    |
    |__
';
    $f[5] = '
    _____
    |/    
    | 
    |
    |
    |
    |__
';
    $f[4] = '
    __
    |/ 
    |
    |
    |
    |
    |__
';
    $f[3] = '
    _
    |
    |
    |
    |
    |
    |__
';
    $f[2] = '
 
    |
    |
    |
    |
    |
    |__
';
    $f[1] = '
 
 
 
 
 
 
    __
';
    $f[0] = '';

    echo '<pre>' . $f[count($_SESSION['wrong_letters'])] . '</pre>';
    ?>

</div>

</body>

</html>