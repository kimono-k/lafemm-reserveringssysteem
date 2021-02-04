<?php
// CRUD - CREATE - By Kevin & Joshua
function createAppointment()
{

    global $connection;

    if (isset($_POST['submit']))
    {
        $afspraak_naam = $_POST['afspraak_naam'];
        $afspraak_email = $_POST['afspraak_email'];
        $afspraak_telefoon = $_POST['afspraak_telefoon'];
        $afspraak_datumentijd = $_POST['afspraak_datumentijd'];
        $afspraak_opmerkingen = $_POST['afspraak_opmerkingen'];

        // Validation.
        if ($afspraak_naam == "" || empty($afspraak_naam))
        {
            echo "Naam mag niet leeg zijn!";

            if ($afspraak_email == "" || empty($afspraak_email))
            {
                echo "E-mail mag niet leeg zijn!";
            }

            if ($afspraak_telefoon == "" || empty($afspraak_telefoon))
            {
                echo "Telefoonnummer mag niet leeg zijn!";
            }

            if ($afspraak_datumentijd == "" || empty($afspraak_datumentijd))
            {
                echo "Datum en tijd mogen niet leeg zijn!";
            }

            if ($afspraak_opmerkingen == "" || empty($afspraak_opmerkingen))
            {
                echo "Opmerkingen moeten wel eerst netjes ingevuld worden!";
            }

            // All fields filled in? - CREATE
            
        }
        
        else
        {
            $query = "INSERT INTO afspraken(afspraak_naam, afspraak_email, afspraak_telefoon, afspraak_datumentijd, afspraak_opmerkingen) ";
            $query .= "VALUES('{$afspraak_naam}', '{$afspraak_email}', '{$afspraak_telefoon}', '{$afspraak_datumentijd}', '{$afspraak_opmerkingen}') ";

            $add_appointment_query = mysqli_query($connection, $query);

            if (!$add_appointment_query)
            {
                die('QUERY FAILED' . mysqli_error($connection));
                exit;
            }
        }
    }
}

// CRUD - READ
function findAppointment()
{
    global $connection;
    $query = "SELECT * FROM afspraken";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories))
    {
        $afspraak_id = $row['afspraak_id'];
        $afspraak_naam = $row['afspraak_naam'];
        $afspraak_email = $row['afspraak_email'];
        $afspraak_telefoon = $row['afspraak_telefoon'];
        $afspraak_datumentijd = $row['afspraak_datumentijd'];
        $afspraak_opmerkingen = $row['afspraak_opmerkingen'];
        //        $cat_id = $row['cat_id'];
        //        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$afspraak_id}</td>"; // CMGT REFACTOR.
        echo "<td>{$afspraak_naam}</td>"; // CMGT REFACTOR.
        echo "<td>{$afspraak_email}</td>";
        echo "<td>{$afspraak_telefoon}</td>";
        echo "<td>{$afspraak_datumentijd}</td>";
        echo "<td>{$afspraak_opmerkingen}</td>";
        echo "<td><a href='klanten.php?delete={$afspraak_id}'>Delete</a></td>";
        echo "<td><a href='klanten.php?edit={$afspraak_id}'>Edit</a></td>";
        echo "</tr>"; // CMGT REFACTOR.
        
    }
}

// CRUD - UPDATE
function updateAppointment()
{
    global $connection;
    if (isset($_GET['edit']))
    {
        $cat_id = $_GET['edit'];
        include "includes/update_categories.php";
    }
}

// CRUD - DELETE
function deleteAppointment()
{
    global $connection;
    // Is the ?delete=x set? - DELETE
    if (isset($_GET['delete']))
    {
        $deleteAppointment = $_GET['delete'];
        $query = "DELETE FROM afspraken WHERE afspraak_id = {$deleteAppointment} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: klanten.php"); // Refreshes the page.
        
    }
}

?>
