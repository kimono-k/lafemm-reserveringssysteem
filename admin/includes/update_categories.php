                        <form action="" method="post">
                          <div class="form-group">
                             <label for="cat-title">Wijzig een afspraak</label>
                             <br>
                             
                             <?php
                             // Is the ?edit=x set? - UPDATE, key, value.
                             if (isset($_GET['edit'])) {
                                 $afspraak_id = $_GET['edit'];
                                 
                                 $query = "SELECT * FROM afspraken WHERE afspraak_id = {$afspraak_id} ";
                                 $select_appointment_id = mysqli_query($connection, $query);
                             
                                 while($row = mysqli_fetch_assoc($select_appointment_id)) {
                                    $afspraak_id = $row['afspraak_id'];
                                    $afspraak_naam = $row['afspraak_naam'];
                                    $afspraak_email = $row['afspraak_email'];
                                    $afspraak_telefoon = $row['afspraak_telefoon'];
                                    $afspraak_datumentijd = $row['afspraak_datumentijd'];
                                    $afspraak_opmerkingen = $row['afspraak_opmerkingen']; 
                             ?>
                                    
                            <input type="hidden" name="afspraak_id" value="<?= $afspraak_id ?>"/>
                            
                            <b>Naam</b>        
                            <input value="<?php if (isset($afspraak_naam)) {echo $afspraak_naam;} ?>" type="text" class="form-control" name="afspraak_naam">
                            <br>
                            
                            <b>E-mail</b>
                            <input value="<?php if (isset($afspraak_email)) {echo $afspraak_email;} ?>" type="email" class="form-control" name="afspraak_email">
                            <br>
                            
                            <b>Telefoonnummer</b>
                            <input value="<?php if (isset($afspraak_telefoon)) {echo $afspraak_telefoon;} ?>" type="tel" class="form-control" name="afspraak_telefoon">
                            <br>
                            
                            <b>Datum en tijd</b>
                            <input value="<?php if (isset($afspraak_datumentijd)) {echo $afspraak_datumentijd;} ?>" type="datetime" class="form-control" name="afspraak_datumentijd">
                            <br>
                            
                            <b>Opmerkingen</b>
                            <input value="<?php if (isset($afspraak_opmerkingen)) {echo $afspraak_opmerkingen;} ?>" type="text" class="form-control" name="afspraak_opmerkingen">
                            
                               
                                <?php }} ?>
                                
                            <?php
                            // CRUD - UPDATE
                            if (isset($_POST['update_appointment'])) {
                                $afspraak_id = $_POST['afspraak_id']; 
                                $afspraak_naam = $_POST['afspraak_naam'];
                                $afspraak_email = $_POST['afspraak_email'];
                                $afspraak_telefoon = $_POST['afspraak_telefoon'];
                                $afspraak_datumentijd = $_POST['afspraak_datumentijd'];
                                $afspraak_opmerkingen = $_POST['afspraak_opmerkingen'];
                                $query = "UPDATE afspraken SET afspraak_naam = '{$afspraak_naam}', afspraak_email = '{$afspraak_email}', afspraak_telefoon = '{$afspraak_telefoon}', afspraak_datumentijd = '{$afspraak_datumentijd}', afspraak_opmerkingen = '{$afspraak_opmerkingen}' WHERE afspraak_id = {$afspraak_id} ";
                                $update_query = mysqli_query($connection, $query);
                                header('Location: klanten.php');
                                
//                                // bob
//                                $query = "UPDATE albums
//                                        SET name = '$name', artist = '$artist', genre = '$genre', year = '$year', tracks = '$tracks', image = '$image' WHERE id = '$albumId'";
                                
                                if (!$update_query) {
                                    die("QUERY FAILED" . mysqli_error($connection));
                                }
                            }  
                            ?>
                    
                          </div>
                          <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="update_appointment" value="Wijzig klant">
                          </div>  
                        </form>