<?php
include "includes/admin_header.php";
?>
        <div id="wrapper">

        <!-- Navigation -->
<?php
include "includes/admin_navigation.php";
?>
        

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       
                        <h1 class="page-header">
                            Welkom in het klantenbestand
                            <small>Muhterem Copur</small>
                        </h1>
                        
                        <div class="col-xs-6">
                        
                        <?php
                        createAppointment();
                        ?>
                                         
                        <form action="" method="post">
                          <div class="form-group">
                              
                              <b>Naam</b>
                              <input type="text" class="form-control" name="afspraak_naam">
                              <br>
                              
                              <b>E-mail</b>
                              <input type="text" class="form-control" name="afspraak_email">
                              <br>
                              
                              <b>Telefoon</b>
                              <input type="text" class="form-control" name="afspraak_telefoon">
                              <br>
                              
                              <b>Datum en tijd</b>
                              <input type="text" class="form-control" name="afspraak_datumentijd">
                              <br>
                              
                              <b>Opmerkingen</b>
                              <input type="text" class="form-control" name="afspraak_opmerkingen">
                              
                          </div>
                          <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="submit" value="Klant toevoegen">
                          </div>  
                        </form>
                        
                        <?php
                        updateAppointment();
                        ?>
                        
                        </div> <!-- Add Category Form -->
                        
                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Afspraak ID</th>
                                    <th>Naam</th>
                                    <th>E-mail</th>
                                    <th>Telefoonnummer</th>
                                    <th>Datum en tijd</th>
                                    <th>Opmerkingen</th>
                                </tr>
                            </thead>
                            <tbody>

                        <?php
                        findAppointment();
                        ?>

                        <?php
                        deleteAppointment();
                        ?>
                            
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        
<?php
include "includes/admin_footer.php";
?>
