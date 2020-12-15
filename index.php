<?php
require 'inc/functions.php';

$pageTitle = "Time Tracker";
$page = null;

include 'inc/header.php';
?>
	<div class="section catalog random">
    <div class="col-container actions-container">

      <h1>Welkom op het reserveringssysteem van La Femm!</h1>
      <p class="actions-copy">Wij willen u alvast bedanken voor uw bezoek.</p>
      <div class="actions-wrapper">
        <ul class="actions">
          <li class="actions-item">
            <a class="actions-link" href="task.php">
              <span class="actions-icon">
                <svg viewbox="0 0 64 64"><use xlink:href="#task_icon"></use></svg>
              </span>
              Afspraak maken
            </a>
          </li>
          <li class="actions-item">
            <a class="actions-link" href="project.php">
              <span class="actions-icon">
                <svg viewbox="0 0 64 64"><use xlink:href="#project_icon"></use></svg>
              </span>
              Behandelingen
            </a>
          </li>
          <li class="actions-item">
            <a class="actions-link" href="reports.php">
              <span class="actions-icon">
                <svg viewbox="0 0 64 64"><use xlink:href="#report_icon"></use></svg>
              </span>
              Afrekenen
            </a>
          </li>
        </ul>
      </div>

		</div>

	</div>

<?php include("inc/footer.php"); ?>
