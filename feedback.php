<?php include('inc/header.php'); ?>
<?php
/*
  The following lines were using mysqli to query our database.
  $sql = 'SELECT * FROM feedback';
  $result = mysqli_query($conn, $sql);
  $feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);
*/

// search through feedback by Name
$filterName = '';
$filterNameErr = '';

// Alternative search method:
// $searchParam = "%$filterName%";
// $sql = "SELECT * FROM feedback WHERE name LIKE ?"
// insert into execute() and it will pull all values that inclue the param.

if (isset($_POST['submit'])) {

  // Validate Name
  if (empty($_POST['filterName'])) {
    $filterNameErr = "Name is required.";
  } else {
    $filterName = filter_input(INPUT_POST, 'filterName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

  if ($_POST['submit'] === 'Reset') {
    unset($_POST);
    $filterName = $filterNameErr = '';
  }
}

// PDO Query
// if no search param, then fetch all; otherwise fetch using Named Params: 'WHERE name = :name'
$sql = empty($filterName) ? 'SELECT * FROM feedback' : 'SELECT * FROM feedback WHERE name = :name';
// Positional Params would look like 'WHERE name = ?'
// and you would use execute([$filterName]) instead.
$stmt = $pdo->prepare($sql);
$stmt->execute(['name' => $filterName]);
$result = $stmt->fetchAll();
?>

<h2>Feedback</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="row g-3 mt-4 w-75">
  <?php if (!empty($filterName)) : ?>
    <div class="col-auto">
      <h4>Filter by <?php echo $filterName ?></h4>
    </div>
  <?php endif; ?>
  <div class="col-auto">
    <input type="text" class="form-control w-100 <?php echo !$filterNameErr ?: 'is-invalid'; ?>" id="filterName" name="filterName" placeholder="Search by Name" />
    <div class="invalid-feedback">
      <?php echo $filterNameErr; ?>
    </div>
  </div>
  <div class="col-auto">
    <input type="submit" name="submit" value="Send" class="btn btn-dark" />
  </div>
  <div class="col-auto">
    <input type="submit" name="submit" value="Reset" class="btn btn-light border" />
  </div>
</form>

<?php foreach ($result as $row) { ?>
  <div class="card my-3 w-75">
    <div class="card-body text-center">
      <!-- I prefer Object $row->body to Array $row['body'] -->
      <?php echo $row->body; ?>
      <div class="text-secondary mt-2">By <?php echo $row->name; ?> on <?php echo $row->date; ?></div>
    </div>
  </div>
<?php }

if (empty($result)) : ?>
  <p class="lead mt-3">There is no feedback.</p>
<?php endif;

include('inc/footer.php'); ?>