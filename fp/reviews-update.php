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

// Update the blog post after the form is submitted
if (isset($_POST['rating'], $_POST['name'], $_POST['content'])) {
    // Check to see if any fields are empty
    if (empty($_POST['name']) || empty($_POST['content'])) {
        $responses[] = "Please complete all fields";
    } else {

        $author = isset($_POST['name']) ? $_POST['name'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;

        $responses[] = $rating;

        $stmt = $pdo->prepare('UPDATE `reviews` SET `name`= ?, `content`= ?, `rating`= ?, `submit_date`= NOW() WHERE `id` = ?');
        $stmt->execute([$author, $content, $rating, $_GET['id']]);

        $headerLocation = 'Location: reviews-admin.php?id=' . $_GET['id'];
        header($headerLocation);
    }
}

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<!-- Responses -->
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>
<h1 class="title">Update Review</h1>

<form action="" method="post">

    <!-- Reviewer -->
    <div class="field">
        <label class="label">Reviewer</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" value="<?= $review['reviewer'] ?>" require>
            <span class="icon is-left">
                <i class="fas fa-user-ninja"></i>
            </span>
        </div>
    </div>

    <!-- Review Date -->
    <div class="field">
        <label class="label">Review Date</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="date" value="<?= $review['review_date'] ?>" require disabled>
            <span class="icon is-left">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
        </div>
    </div>

    <!-- Review -->
    <div class="field">
        <label class="label">Content</label>
        <div class="control">
            <textarea class="textarea" name="content" require><?= $review['content'] ?></textarea>
        </div>
    </div>

    <!-- Rating -->

    <div class="field">
        <div class="control">
            <label class="radio">
                <input type="radio" name="rating" value="1" required <?= $oneStar ?>> &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="2" required <?= $twoStar ?>> &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="3" required <?= $threeStar ?>> &#9733; &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="4" required <?= $fourStar ?>> &#9733; &#9733; &#9733; &#9733;
            </label>
            <br />
            <label class="radio">
                <input type="radio" name="rating" value="5" required <?= $fiveStar ?>> &#9733; &#9733; &#9733; &#9733; &#9733;
            </label>
            <br />
        </div>
    </div>
    <!-- Create Button -->
    <div class="field is-grouped is-grouped-left">
        <p class="control">
            <Button class="button is-primary">
                Update
            </button>
        </p>
        <!-- Cancel Button -->
        <p class="control">
            <a href="admin.php" class="button is-light">
                Cancel
            </a>
        </p>
    </div>
</form>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>