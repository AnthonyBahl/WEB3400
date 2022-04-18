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

// get 10 most recent blog posts
$stmt = $pdo->query("SELECT `id`, `title`, `author_name`, DATE_FORMAT(`created`, '%M %D %Y') AS date_created, LEFT(`content`, 100) AS content_preview
                     FROM `blog_post`
                     WHERE `published`
                     ORDER BY `created` DESC
                     LIMIT 10");
$recentBlogPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Admin Dashboard') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN -->
    <div class="column is-one-fifth">
        <?= admin_nav(basename(__FILE__)) ?>
    </div>
    <!-- END LEFT NAV COLUMN -->
    <!-- START RIGHT CONTENT COLUMN-->
    <div>
        <h1 class="title">Recent Blog Posts</h1>
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light">
                <?php echo implode('<br>', $responses); ?>
            </p>
        <?php endif; ?>
        <?php foreach ($recentBlogPosts as $post) : ?>
            <div class="box">
                <h1 class="title is-4"><?= htmlspecialchars($post['title'], ENT_QUOTES) ?></h1>
                <h2 class="subtitle is-6"><?= htmlspecialchars($post['author_name'], ENT_QUOTES) ?>
                    -
                    <?= htmlspecialchars($post['date_created'], ENT_QUOTES) ?></h2>
                <p>
                    <?= htmlspecialchars($post['content_preview'], ENT_QUOTES) ?>
                    ... <a href="blog-post.php?id=<?= $post['id'] ?>">read more</a>
                </p>
            </div>
        <?php endforeach ?>
    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>
<!-- END PAGE CONTENT -->
<?= template_footer() ?>