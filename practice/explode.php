<?php

function wordDigit($word) {
    echo "$word<br />";                         // Output their input
    $array = explode("-", $word);               // Convert to an array
    $result = "";                               // Create result string
    foreach ($array as $key => $value) {        // Loop through array
        switch (strtolower(trim($value))) {     // Trim white space and convert to lowercase
            case 'zero':
                $result = $result . "0";
                break;
            case 'one':
                $result = $result . "1";
                break;
            case 'two':
                $result = $result . "2";
                break;
            case 'three':
                $result = $result . "3";
                break;
            case 'four':
                $result = $result . "4";
                break;
            case 'five':
                $result = $result . "5";
                break;
            case 'six':
                $result = $result . "6";
                break;
            case 'seven':
                $result = $result . "7";
                break;
            case 'eight':
                $result = $result . "8";
                break;
            case 'nine':
                $result = $result . "9";
                break;
        }
    }
    return $result;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script defer src="js/bulma.js"></script>
    <title>Explode</title>
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Explode!</h1>
            <form method="get" action="">
                <div class="field">
                    <label class="label">Enter one or more number names with a dash between each</label>
                    <div class="control has-icons-left">
                        <input name="numberNames" class="input" type="text" placeholder="one-two-three" required>
                        <span class="icon is-left">
                            <i class="fab fa-slack-hash"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-success">
                            Compute
                        </button>
                    </div>
                </div>
            </form>
            &nbsp;
            <?php if (isset($_GET['numberNames'])) : ?>
                <h2 class="subtitle">Output:</h2>
                <div class="notification content">
                    <p><?= wordDigit($_GET['numberNames']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>