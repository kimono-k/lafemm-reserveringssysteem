<?php
require 'inc/functions.php';

$page = "projects";
$pageTitle = "La Femm Reserveringssysteem | Behandelingen toevoegen";

if (isset($_POST['delete'])) { // if post is set then...
  if (delete_project(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
    header('location: project_list.php?msg=Project+Deleted'); // Redirect.
    exit; // Stop all code from executing.
  } else { // if post is not set then...
    header('location: project_list.php?msg=Unable+to+Delete+Project'); // Redirect.
    exit; // Stop all code from executing.
  }
}

if (isset($_GET['msg'])) {
  $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

include 'inc/header.php';
?>
<div class="section catalog random">

    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Voeg een behandeling toe</h1>
            <div class="actions-item">
                <a class="actions-link" href="project.php">
                <span class="actions-icon">
                  <svg viewbox="0 0 64 64"><use xlink:href="#project_icon"></use></svg>
                </span>
                Behandeling toevoegen
                </a>
            </div>
            <?php
            if (isset($error_message)) { // If the error message is set then...
              echo "<p class='message'>$error_message</p>";
            }
            ?>

            <div class="form-container">
                <ul class="items">
                  <!-- Iterate through the query results :D -->
                  <?php  
                  foreach (get_project_list() as $item) { // Iterate through query.
                    echo "<li><a href='project.php?id=" . $item['project_id'] . "'>" . $item['title'] . "</a>"; // DB ROW = $item['dbrow'], all links.
                    echo "<form method='post' action='project_list.php' onsubmit=\"return confirm('Are you sure you want to delete this project?');\">\n";
                    
                    echo "<input type='hidden' value='". $item['project_id'] . "' name='delete' />\n";
                    echo "<input type='submit' class='button--delete' value='Delete' />\n";
                    echo "</form>";
                    echo "</li>";
                  }
                  ?>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php include("inc/footer.php"); ?>
