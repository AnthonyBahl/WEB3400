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

$stmt = $pdo->query("SELECT `id` AS review_id, `page_id` AS post_id, `name` AS reviewer, LEFT(`content`, 100) AS review_content, `rating`, DATE_FORMAT(`submit_date`, '%M %D %Y') AS review_date
                     FROM `reviews`
                     ORDER BY `submit_date` DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- START BLOG TABLE CONTENT -->
<div class="box">
    <h1 class="title is-4">Reviews</h1>
    <hr />
    <table class="table is-striped is-narrow is-hoverable is-fullwidth">
        <thead style="background-color: #D3D3D3">
            <tr>
                <th><abbr title="Blog that the review is associated to.">Blog ID</abbr></th>
                <th>Rating</th>
                <th>Review</th>
                <th>Author</th>
                <th>Review Date</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <?php foreach ($reviews as $review) : ?>
            <tr>
                <td><?= $review['post_id'] ?></td>
                <td><?= $review['rating'] ?></td>
                <td><?= $review['review_content'] ?></td>
                <td><?= $review['reviewer'] ?></td>
                <td><?= $review['review_date'] ?></td>
                <td>
                    <a href="blog-post.php?id=<?= $review['post_id'] ?>" class='button is-info'>
                        <span class='icon'>
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </a>
                </td>
                <td>
                    <a href="reviews-update.php?id=<?= $review['review_id'] ?>" class='button is-primary'>
                        <span class='icon'>
                            <i class='fas fa-edit'></i>
                        </span>
                    </a>
                </td>
                <td>
                    <a href="reviews-delete.php?id=<?= $review['review_id'] ?>" class='button is-danger'>
                        <span class='icon'>
                            <i class='fas fa-trash-alt'></i>
                        </span>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<!-- END BLOG TABLE CONTENT -->