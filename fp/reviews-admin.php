<?php
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

// Start the session
session_start();

// If the user is not logged in redirect them to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$pdo = pdo_connect_mysql();

// Your MySQL query that selects the blog post goes here
if (isset($_GET['id'])) {

    // MySQL query that selects the poll records by the GET request "id"
    $stmt = $pdo->prepare("SELECT `id` AS review_id, `name` AS reviewer, `content`, `rating`, DATE_FORMAT(`submit_date`, '%M %D %Y') AS review_date
                        FROM `reviews`");
    $stmt->execute([$_GET['id']]);

    // Fetch the record
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    $oneStar = '';
    $twoStar = '';
    $threeStar = '';
    $fourStar = '';
    $fiveStar = '';

    switch ($review['rating']) {
        case '1':
            $oneStar = 'checked';
            break;
        case '2':
            $twoStar = 'checked';
            break;
        case '3':
            $e = 'checked';
            break;
        case '4':
            $fourStar = 'checked';
            break;
        case '5':
            $fiveStar = 'checked';
            break;
    }
} else {
    die('No ID specified.');
}

?>

<?= template_header('Page Title') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<!-- Responses -->
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>

<form action="" method="post">

    <!-- Reviewer -->
    <div class="field">
        <label class="label">Reviewer</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" value="<?= $review['reviewer'] ?>" require disabled>
            <span class="icon is-left">
                <i class="fas fa-user-ninja"></i>
            </span>
        </div>
    </div>

    <!-- Review Date -->
    <div class="field">
        <label class="label">Review Date</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" value="<?= $review['review_date'] ?>" require disabled>
            <span class="icon is-left">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
        </div>
    </div>

    <!-- Review -->
    <div class="field">
        <label class="label">Content</label>
        <div class="control">
            <textarea class="textarea" name="content" require disabled><?= $review['content'] ?></textarea>
        </div>
    </div>

    <!-- Rating -->

    <div class="field">
        <div class="control">
            <label class="radio">
                <input type="radio" name="rating" value="1" required <?= $oneStar ?> disabled> &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="2" required <?= $twoStar ?> disabled> &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="3" required <?= $threeStar ?> disabled> &#9733; &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="4" required <?= $fourStar ?> disabled> &#9733; &#9733; &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="5" required <?= $fiveStar ?> disabled> &#9733; &#9733; &#9733; &#9733; &#9733;
            </label>
            <br />
        </div>
    </div>
    <!-- Create Button -->
    <div class="field is-grouped is-grouped-left">
        <p class="control">
            <a href="reviews-update.php?id=<?= $review['review_id'] ?>" class="button is-primary">
                Edit
            </a>
        </p>
        <!-- Cancel Button -->
        <p class="control">
            <a href="admin.php" class="button is-light">
                Return to Admin
            </a>
        </p>
    </div>
</form>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>