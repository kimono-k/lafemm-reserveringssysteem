<?php
require 'inc/functions.php';

$page = "tasks";
$pageTitle = "La Femm Reserveringssysteem | Mijn afspraken";

if (isset($_POST['delete'])) { // if post is set then...
  if (delete_task(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
    header('location: task_list.php?msg=Task+Deleted'); // Redirect.
    exit; // Stop all code from executing.
  } else { // if post is not set then...
    header('location: task_list.php?msg=Unable+to+Delete+Task'); // Redirect.
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

            <h1 class="actions-header">Mijn afspraken</h1>
            <div class="actions-item">
                <a class="actions-link" href="task.php">
                    <span class="actions-icon">
                        <svg viewbox="0 0 64 64"><use xlink:href="#task_icon"></use></svg>
                    </span>
                Maak een afspraak</a>
            </div>
            <?php
            if (isset($error_message)) { // If the error message is set then...
              echo "<p class='message'>$error_message</p>";
            }
            ?>

            <div class="form-container">
              <ul class="items">
                 <?php  
                  foreach (get_task_list() as $item) { // Iterate through query.
                    echo "<li><a href='task.php?id=" . $item['task_id'] . "'>" . $item['title'] . "</a>";
                    echo "<form method='post' action='task_list.php' onsubmit=\"return confirm('Are you sure you want to delete this task?');\">\n";
                    
                    echo "<input type='hidden' value='". $item['task_id'] . "' name='delete' />\n";
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
