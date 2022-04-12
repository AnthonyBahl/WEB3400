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

$stmt = $pdo->query("SELECT `id`, `title`, `author_name`, `published`, DATE_FORMAT(`created`, '%M %D %Y') AS date_created
                     FROM `blog_post`
                     ORDER BY `created` DESC");
$blogPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT `id` AS review_id, `page_id` AS post_id, `name` AS reviewer, LEFT(`content`, 100) AS review_content, `rating`, DATE_FORMAT(`submit_date`, '%M %D %Y') AS review_date
                     FROM `reviews`
                     ORDER BY `submit_date` DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN -->
    <div class="column is-one-fifth">
        <?= admin_nav(basename(__FILE__)) ?>
    </div>
    <!-- END LEFT NAV COLUMN -->
    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column">
        <h1 class="title">Admin Dashboard</h1>
        <!-- Responses -->
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light">
                <?php echo implode('<br>', $responses); ?>
            </p>
        <?php endif; ?>
        <div class="box">
            <h1 class="title is-4">Blog Posts</h1>
            <hr />
            <a href="blog-create.php" class="button is-success">Create a New Post</a>
            <br /><br />
            <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                <thead style="background-color: #D3D3D3">
                    <tr>
                        <th><abbr title="Number">#</abbr></th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Creation Date</th>
                        <th>Published?</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <?php foreach ($blogPosts as $post) : ?>
                    <tr>
                        <th><?= $post['id'] ?></th>
                        <td><?= $post['title'] ?></td>
                        <td><?= $post['author_name'] ?></td>
                        <td><?= $post['date_created'] ?></td>
                        <td style='text-align: center'>
                            <?php if ($post['published'] == 1) : ?>
                                <i class="fa-solid fa-check"></i>
                            <?php else : ?>
                                <i class="fa-solid fa-xmark"></i>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="blog-post.php?id=<?= $post['id'] ?>" class='button is-info'>
                                <span class='icon'>
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </a>
                        </td>
                        <td>
                            <a href="blog-update.php?id=<?= $post['id'] ?>" class='button is-primary'>
                                <span class='icon'>
                                    <i class='fas fa-edit'></i>
                                </span>
                            </a>
                        </td>
                        <td>
                            <a href="blog-delete.php?id=<?= $post['id'] ?>" class='button is-danger'>
                                <span class='icon'>
                                    <i class='fas fa-trash-alt'></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
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
                            <a href="reviews-admin.php?id=<?= $review['review_id'] ?>" class='button is-info'>
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

    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>
<!-- END PAGE CONTENT -->
<?= template_footer() ?>