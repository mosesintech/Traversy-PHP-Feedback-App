<?php include('inc/header.php');

$name = $email = $body = '';
$nameErr = $emailErr = $bodyErr = '';

if (isset($_POST['submit'])) {
    // Validate Name
    if (empty($_POST['name'])) {
        $nameErr = "Name is required.";
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Validate Email
    if (empty($_POST['email'])) {
        $emailErr = "Email is required.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }

    // Validate Body
    if (empty($_POST['body'])) {
        $bodyErr = "Feedback is required.";
    } else {
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($nameErr) && empty($emailErr) && empty($bodyErr)) {
        // Add to the database
        $sql = "INSERT INTO feedback (name, email, body) VALUES ('$name', '$email', '$body')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'body' => $body]);
        header('Location: feedback.php');
        // The following lines were using mysqli to insert data into our database.
        // if (mysqli_query($conn, $sql)) {
        //     // Successfully inserted
        //     header('Location: feedback.php');
        // } else {
        //     echo 'Error ' . mysqli_error($conn);
        // }
    }
}
?>

<div class="d-flex flex-column align-items-center w-25">
    <img src="./img/logo.png" class="w-25" alt="" />
</div>
<h2>Feedback</h2>
<p class="lead text-center">Leave feedback for Traversy Media</p>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="mt-4 w-75">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" id="name" name="name" placeholder="Enter your name" />
        <div class="invalid-feedback">
            <?php echo $nameErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" id="email" name="email" placeholder="Enter your email" />
        <div class="invalid-feedback">
            <?php echo $emailErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Feedback</label>
        <textarea class="form-control <?php echo !$bodyErr ?: 'is-invalid'; ?>" id="body" name="body" placeholder="Enter your feedback"></textarea>
        <div class="invalid-feedback">
            <?php echo $bodyErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100" />
    </div>
</form>

<?php include('inc/footer.php'); ?>