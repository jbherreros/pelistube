<?php 
    include "connection.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
    //contracte actual
    $contract = $_SESSION['IdContracte'];
    //tota la informació de les factures amb el contracte
    $consulta = "SELECT * FROM factura WHERE IdContracte = '".$contract."' AND dataPagament IS NOT NULL";
    $cerca = mysqli_query($con,$consulta);
    //mirem si hi ha factures
    if (mysqli_num_rows($cerca) < 1) {
        header("Location: noHiHaFactures.php?redir=veureFactures.php");
        die();
    }
      
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
</head>
    <body>
        <header>
            <?php include "navbar.php"; ?>
        </header>
        <section>
        <?php
            //recorregut de la taula de factures
            while($fila = mysqli_fetch_assoc($cerca)){
                //variables que contenen els valors que volem mostrar als missatges
                $trob = $fila["IdFactura"];
                $datapagfila = $fila["dataPagament"];
                $dataInfila = $fila["dataInici"];
                $dataFifila = $fila["dataFinal"];
                $importfila = $fila["import"];

                //taula de bootstrap que imprimirà la factura, la data en la qual s'ha realitzat el pagament
                //la data inici, la data fi i l'import de les factures que ja han estat pagades
                

                echo '<div class="container">
                <div class = "padding"><br></div>
                <div class = "row">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                        <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Factura</th>
                            <th scope="col">Fecha de pago</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de finalización</th>
                            <th scope="col">Importe</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>'.$trob.'</td>
                            <td>'.$datapagfila.'</td>
                            <td>'.$dataInfila.'</td>
                            <td>'.$dataFifila.'</td>
                            <td>'.$importfila.'</td>
                          </tr>
                        </tbody>
                      </table>
                        </div>        
                    </div>
            </div>';
                
            }
        
        ?>
        </section>


        <section style="padding-left: 4% ;">
            <!--botó per a tornar enrera-->
            <form action="veureFactures.php" method="post" id="$trob">
                <button type="submit" class="btn btn-danger" style="width:100px">Atrás</button>
                <div class = "padding"><br></div>
            </form>
        </section>

        
        <!-- Frameworks -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>