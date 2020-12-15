<?php
try { // Try this.
  $db = new PDO("sqlite:".__DIR__."/database.db"); // New pdo object, with arguments.
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // All errors should be handled as an exception.
} catch (Exception $e) { // If it fails then...
  echo $e->getMessage(); // Show error message.
  exit; // Stop all code from executing.
}
?>