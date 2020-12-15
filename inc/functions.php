<?php
//application functions - CRUD System Kevin Narain
function get_project_list() { // R = Read
  include "connection.php";
  
  try { // Try this...
    return $db->query("SELECT project_id, title, category FROM projects"); // What do you want to with this query?
  } catch (Exception $e) { // If it fails then...
    echo "Error!: " . $e->getMessage() . "</br>"; // Show error message.
    return array(); // What do you want to do with array?
  }
}

function get_task_list($filter = null) { // R = Read, Function with parameter.
  include "connection.php";
  
  $sql = 'SELECT tasks.*, projects.title AS project FROM tasks'
    . ' JOIN projects ON tasks.project_id = projects.project_id'; // tasks.project_id = PK projects.project_id = FK.
  
  $where = ''; // Empty string.
  if (is_array($filter)) { // If filter is an array then (when submit is pressed get)...
    switch ($filter[0]) { // Compare first array element (0).
      case 'project'; // If it's project then...
        $where = ' WHERE projects.project_id = ?';
        break; // Stop.
      case 'category': // If it's category then...
        $where = ' WHERE category = ?';
        break; // Stop.
      case 'date':
        $where = ' WHERE date >= ? AND date <= ?';
        break;
    }
  }
  
  $orderBy = ' ORDER BY date DESC'; // From large to small.
  if ($filter) { // if $filter is true then...
    $orderBy = ' ORDER BY projects.title ASC, date DESC'; // Order A-Z, Order Z-A.
  }
  
  try { // Try this...
    $results = $db->prepare($sql . $where . $orderBy); // Prevents SQL-injections.
    if (is_array($filter)) { // If the filter is an array then...
      $results->bindValue(1, $filter[1]); // Binds a value to a parameter -- 1st placeholder, which parameter?
      if ($filter[0] == 'date') { // if $filter array is 0 is equal to date then...
        $results->bindValue(2, $filter[2], PDO::PARAM_STR);
      }
    }
    $results->execute(); // Executes a prepare statement.
  } catch (Exception $e) { // If it fails then...
    echo "Error!: " . $e->getMessage() . "</br>"; // Show error message.
    return array(); // What do you want to do with array?
  }
  return $results->fetchAll(PDO::FETCH_ASSOC); // Returns an array containing all of the result set rows, tells PDO to return the result as an associative array.
}

// C = CREATE FOR PROJECTS
function add_project($title, $category, $project_id = null) { // Function with 3 parameters.
    include "connection.php"; // DB connect.
    
    if ($project_id) { // If project_id is true then... U = UPDATE.
      $sql = 'UPDATE projects SET title = ?, category = ? WHERE project_id = ?';
    } else { // if project_id is null then...
      $sql = 'INSERT INTO projects(title, category) VALUES(?, ?)'; // ? responds to args.  
    }
    
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $title, PDO::PARAM_STR); // Binds a value to a parameter -- 1st placeholder, which parameter?, data type of param.
      $results->bindValue(2, $category, PDO::PARAM_STR); // Binds a value to a parameter -- 2nd placeholder, which parameter?, data type of param.
      if ($project_id) { // if project_id is true then...
        $results->bindValue(3, $project_id, PDO::PARAM_INT);
      }
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    return true; // What do you want to do with true?
}

// C = CREATE FOR PROJECTS
function get_project($project_id) { // Function with 1 parameter.
    include "connection.php"; // DB connect.
  
    $sql = "SELECT * FROM projects WHERE project_id = ?";
    
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $project_id, PDO::PARAM_INT);
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    return $results->fetch(); // Fetches the next row from a result set.
}


function get_task($task_id) { // Function with 1 parameter.
    include "connection.php"; // DB connect.
  
    $sql = "SELECT task_id, title, date, time, project_id FROM tasks WHERE task_id = ?";
    
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $task_id, PDO::PARAM_INT);
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    return $results->fetch(); // Fetches the next row from a result set.
}

// CRUD -> D = Delete
function delete_task($task_id) { // Function with 1 parameter.
    include "connection.php"; // DB connect.
  
    $sql = "DELETE FROM tasks WHERE task_id = ?";
    
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $task_id, PDO::PARAM_INT);
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    return true; // Fetches the next row from a result set.
}

function delete_project($project_id) { // Function with 1 parameter.
    include "connection.php"; // DB connect.
  
    $sql = 'DELETE FROM projects WHERE project_id = ?'
      . ' AND project_id NOT IN (SELECT project_id FROM tasks)';
    
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $project_id, PDO::PARAM_INT);
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    
    if ($results->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
}

// C = CREATE FOR TASKS.
function add_task($project_id, $title, $date, $time, $task_id = null) { // Function with 5 parameters.
    include "connection.php"; // DB connect.
    
    if ($task_id) { // if the task_id is true then...
        $sql = 'UPDATE tasks SET project_id = ?, title = ?, date = ?, time = ? '
        . ' WHERE task_id = ?';
    } else {
        $sql = 'INSERT INTO tasks(project_id, title, date, time) VALUES(?, ?, ?, ?)'; // ? responds to args.    
    }
      
    try { // Try this.
      $results = $db->prepare($sql); // Prevents SQL injection.
      $results->bindValue(1, $project_id, PDO::PARAM_INT); // Binds a value to a parameter -- 1st placeholder, which parameter?, data type of param.
      $results->bindValue(2, $title, PDO::PARAM_STR); // Binds a value to a parameter -- 1st placeholder, which parameter?, data type of param.
      $results->bindValue(3, $date, PDO::PARAM_STR); // Binds a value to a parameter -- 1st placeholder, which parameter?, data type of param.
      $results->bindValue(4, $time, PDO::PARAM_INT); // Binds a value to a parameter -- 2nd placeholder, which parameter?, data type of param.
      if ($task_id) { // If task id is true then...
          $results->bindValue(5, $task_id, PDO::PARAM_INT);
      }
      $results->execute(); // Executes a prepared statement.
    } catch (Execption $e) { // If it fails then...
      echo "Error!: " . $e->getMessage() . "<br />"; // Print this.
      return false; // What do you want to do with false?
    }
    return true; // What do you want to do with true?
}


