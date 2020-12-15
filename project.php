<?php
require 'inc/functions.php';

// CRUD System: Kevin Narain - CREATE
$pageTitle = "La Femm Reservingssysteem | Behandelingen toevoegen";
$page = "projects";
$title = $category = '';

if (isset($_GET['id'])) { // If the id field is filled in then...
  list($project_id, $title, $category) = get_project(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request method in html form POST then...
  $project_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING)); // trim = remove all whitespace in input, input type = POST, title variable corresponds to html name, remove tags and remove or encode special characters from a string.
  $category = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING));
  
  if (empty($title) || empty($category)) { // If the title OR category are empty then...
    $error_message = "Please fill in the required fields: Title, Category";
  } else { // If it's not empty then...
    if (add_project($title, $category, $project_id)) { // If this function is true then.
      header("Location: project_list.php"); // Redirect to this page.
      exit; // Stop the script from executing.
    } else { // if the function is false then...
      $error_message = "Could not add project"; // Set error message to.
    }
  }
}

include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header"><?php
            if (!empty($project_id)) { // if the project_id is not empty then.
              echo "Update";
            } else {
              echo 'Voeg een behandeling toe';
            }
            ?> </h1>
            <?php
            if (isset($error_message)) { // If the error message is set then...
              echo "<p class='message'>$error_message</p>";
            }
            ?>
            <!-- Form: Post method HTML -->
            <form class="form-container form-add" method="post" action="project.php">
                <table>
                    <tr>
                        <th><label for="title">Title<span class="required">*</span></label></th>
                        <td><input type="text" id="title" name="title" value="<?php echo $title; ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="category">Category<span class="required">*</span></label></th>
                        <td><select id="category" name="category">
                                <option value="">Select One</option>
                                <option value="Billable"<?php
                                  if ($category == 'Billable') {
                                    echo ' selected';
                                  }
                                  ?>>Billable</option>
                                <option value="Charity"<?php
                                  if ($category == 'Charity') {
                                    echo ' selected';
                                  }
                                  ?>>Charity</option>
                                <option value="Personal"<?php
                                  if ($category == 'Personal') {
                                    echo ' selected';
                                  }
                                  ?>>Personal</option>
                                
                        </select></td>
                    </tr>
                </table>
                <?php
                if (!empty($project_id)) { // If the project id is not empty then...
                  echo '<input type="hidden" name="id" value="' . $project_id . '" />';
                }
                ?>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
