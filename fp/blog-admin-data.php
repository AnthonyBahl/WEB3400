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

?>

<!-- START BLOG TABLE CONTENT -->
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

<!-- END BLOG TABLE CONTENT -->