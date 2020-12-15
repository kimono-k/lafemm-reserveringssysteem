<?php
require 'inc/functions.php';

$page = "reports";
$pageTitle = "La Femm Reserveringssysteem | Afrekenen";
$filter = 'all';

// $_GET responds to filter name attribute in HTML.
if (!empty($_GET['filter'])) { // If get filter string query is not empty then...
  $filter = explode(':', filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING)); // Break string into array, Input type = Get, title variable corresponds to html name, remove tags and remove or encode special characters from a string.
}

include 'inc/header.php';
?>
<div class="col-container page-container">
    <div class="col col-70-md col-60-lg col-center">
        <div class="col-container">
            <h1 class='actions-header'>Afrekenen<?php
            if (!is_array($filter)) { // If the filter is not an array then...
              echo ""; // Print this.
            } else { // If the element is an array then...
              echo ucwords($filter[0]) . " : "; // Print UPPERCASE[0].
              switch ($filter[0]) { // Compare this...
                case 'project': // If it's project then.
                  $project = get_project($filter[1]);
                  echo $project['title'];
                  break;
                case 'category':
                  echo $filter[1];
                  break;
                case 'date':
                  echo $filter[1] . " - " . $filter[2];
                  break;
              }
            }
            ?></h1>
            <form class='form-container form-report' action='reports.php' method='get'>
              <label for='filter'>Filter:</label>
              <select id='filter' name='filter'> <!-- $_GET response -->
                <option value=''>Select One</option>
                <optgroup label="Project">
                <?php
                foreach (get_project_list() as $item) { // Iterate through query.
                  echo '<option value="project:' . $item['project_id'] . '">'; // [dbc-i]
                  echo $item['title'] . "</option>\n"; // [dbc-i]
                }
                ?>
                </optgroup>
                <optgroup label="Category">
                  <option value="category:Billable">Billable</option>
                  <option value="category:Charity">Charity</option>
                  <option value="category:Personal">Personal</option>
                </optgroup>
                <optgroup label="Date">
                  <option value="date:<?php 
                  echo date('m/d/Y', strtotime('-2 Sunday')); // Start of last week.
                  echo ":";
                  echo date('m/d/Y', strtotime('-1 Saturday')); // Ending date.
                  ?>">Last Week</option>
                  <option value="date:<?php 
                  echo date('m/d/Y', strtotime('-1 Sunday')); // Start of last week.
                  echo ":";
                  echo date('m/d/Y'); // Ending date.
                  ?>">This Week</option>
                  <option value="date:<?php 
                  echo date('m/d/Y', strtotime('first day of last month')); // Start of last week.
                  echo ":";
                  echo date('m/d/Y', strtotime('last day of last month')); // Ending date.
                  ?>">Last Month</option>
                  <option value="date:<?php 
                  echo date('m/d/Y', strtotime('first day of this month')); // Start of last week.
                  echo ":";
                  echo date('m/d/Y'); // Ending date.
                  ?>">This Month</option>
                </optgroup>
              </select>
              <input class="button" type="submit" value="Run" />
            </form>
        </div>
        <div class="section page">
            <div class="wrapper">
                <table>
                  <?php
                  $total = $project_id = $project_total = 0;
                  $tasks = get_task_list($filter);
                  foreach ($tasks as $item) { // Iterate through query, $item++;
                    if ($project_id != $item['project_id']) { // If project_id is not equal to item then...
                      $project_id = $item['project_id']; // Set project_id equal to item.
                      echo "<thead>\n"; // Print this.
                      echo "<tr>\n"; // Print this.
                      echo "<th>" . $item['project'] . "</th>\n"; // [dbcolumn].
                      echo "<th>Date</th>\n"; // Print this.
                      echo "<th>Time</th>\n"; // Print this.
                      echo "</tr>\n"; // Print this.
                      echo "</thead>\n"; // Print this.
                    }
                    $project_total += $item['time']; // Count value time rows together.
                    $total += $item['time']; // Count value time rows together.
                    echo "<tr>\n"; // Print this.
                    echo "<td>". $item['title'] . "</td>\n"; // ['dbcolumn'].
                    echo "<td>". $item['date'] . "</td>\n"; // ['dbcolumn'].
                    echo "<td>". $item['time'] . "</td>\n"; // ['dbcolumn'].
                    echo "<tr>\n"; // Print this.
                     if (next($tasks)['project_id'] != $item['project_id']) { // If the next project id does NOT equal the current item then...
                        echo "<tr>\n";
                        echo "<th class='project-total-label' colspan='2'>Project Total</th>\n";
                        echo "<th class='project-total-number'>$project_total</th>\n";
                        echo "</tr>\n";
                        $project_total = 0; // Set project back to zero.
                      }
                  }
                  ?>
                    <tr>
                        <th class='grand-total-label' colspan='2'>Totaalbedrag</th>
                        <th class='grand-total-number'><?php echo "€" . $total; // Print total time rows. ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

