<?php
require 'config.php';

$responses = [];

// use PDO to connect to our database
$pdo = pdo_connect_mysql();

if (isset($_POST['name'], $_POST['email'], $_POST['phone'])) {
    // Check to see if the contact already exists
    if ($stmt = $pdo->prepare('SELECT * FROM contacts WHERE email = ?')) {
        $stmt->execute([$_POST['email']]);
        if ($stmt->rowCount() > 0) {
            $responses[] = "There is already a record with that email.";
        } else {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $title = isset($_POST['title']) ? $_POST['title'] : '';

            $stmt = $pdo->prepare('INSERT INTO `contacts`(`name`, `email`, `phone`, `title`, `created`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)');
            $stmt->execute([$name, $email, $phone, $title]);
            $responses[] = 'The record was created.';
            header('Location: contacts.php');
        }
    } else {
        $responses = "Could not prepare SQL statement.";
    }
}

?>

<?= template_header('Create new contact') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Create New Contact</h1>

<!-- Response -->
<?php if($responses) :?>
            <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                echo "<br>";
                var_dump($_POST);?></p>
        <?php endif; ?>

<form action="" method="post">
    <!-- Name -->
    <div class="field">
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" placeholder="John Doe" require>
            <span class="icon is-left">
                <i class="fas fa-user-ninja"></i>
            </span>
        </div>
    </div>
    <!-- Email -->
    <div class="field">
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" placeholder="jdoe@example.com" require>
            <span class="icon is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <!-- Phone -->
    <div class="field">
        <label class="label">Phone</label>
        <div class="control has-icons-left">
            <input class="input" type="tel" name="phone" placeholder="000-867-5309" require>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <!-- Title -->
    <div class="field">
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" placeholder="Ninja">
            <span class="icon is-left">
                <i class="fas fa-tag"></i>
            </span>
        </div>
    </div>
    <!-- Update Button -->
    <div class="field is-grouped is-grouped-left">
        <p class="control">
            <button class="button is-primary">
                Create
            </button>
        </p>
    <!-- Cancel Button -->
        <p class="control">
            <button class="button is-light">
                Cancel
            </button>
        </p>
    </div>
</form>

<?= template_footer() ?>