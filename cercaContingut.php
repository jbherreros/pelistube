<?php session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
        die();
    }
    $resultatCerca = $_POST['cercador'];
    include "connection.php";
    
    //Cercam a la base de dades els continguts a mostrar
    $query = "SELECT * from contingut JOIN categoria ON(categoria.visible = 1 AND contingut.visible = 1 AND contingut.nomCat = categoria.nomCat) WHERE (titol LIKE '$resultatCerca%')";
    $result = mysqli_query($con,$query);
    $res = mysqli_fetch_array($result);
    
                                   
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width">
    <title>PelisTube - Tu plataforma de streaming</title> <!--Título que aparecerá en la pestaña del navegador-->
    <link rel="stylesheet" href="css/bootstrap.min.css"/> <!-- Importamos hoja de estilos de bootrstrap-->
    <link rel="stylesheet" href="styles.css"/> <!-- Nuestra propia hoja de estilos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
</head>
    <body>

        <header>
            <?php 
                include "navbar.php"; 
                include "missatge.php";
            ?>
        </header>

        <section>
            <div class="padding"></div>
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                            <div class="row">
                            <h5>Nuestras películas
                            <?php 
                                if($_SESSION['administrador']==1){ //Si és l'administrador posam el botó Añadir contenido
                                    echo '&nbsp&nbsp<a href="afegirContingutForm.php" class="btn btn-outline-primary btn-sm">
                                    <i class="bi-plus-circle" title="Añadir contenido" style="font-size: 0.9rem;"></i> Añadir contenido
                                    </a>';
                                }
                            ?>
                            </h5></div>

                            <div class="padding"></div>
                            <center>
                            <div class="row justify-content-center gap-2">                                
                                <?php
                                    //Cercam els resultats que són visibles
                                    $query = "SELECT * from contingut JOIN categoria ON(categoria.visible = 1 AND contingut.visible = 1 AND contingut.nomCat = categoria.nomCat) WHERE (titol LIKE '$resultatCerca%')";
                                    $result = mysqli_query($con,$query);
                                     
                                    if (isset($res)){ //Si hi ha contingut
                                        //Bucle que ens mostra tots els continguts
                                        while($row = mysqli_fetch_array($result)){
                                            if(isset($_SESSION['IdContracte'])){
                                                $query2 = "SELECT * from contingutfavorits where IdContracte=".$_SESSION['IdContracte']." and IdContingut=".$row['IdContingut'].""; // Per comprovar si ja està a la llista de favorits
                                                $result2 = mysqli_query($con,$query2);
                                                $fav = mysqli_fetch_array($result2);
                                            }

                                            //Imprimim el botó per veure el contingut
                                            echo   '<div class="col">
                                                        <div class="card" style="width: 12rem;">
                                                            <img class="card-img-top" src=".'.$row['camiFoto'].'" alt="'.$row['titol'].'.png" height="250">
                                                            <div class="card-body">
                                                                <center><h6>'.$row['titol'].'</h6>
                                                                <div class="padding"></div>
                                                                <a href="veureContingut.php?id='.$row['IdContingut'].'" class="btn btn-danger btn-sm">Ver película</a> ';

                                            if(isset($fav)){ // Imprimim el botó per eliminar favorit
                                                echo            '<a href="eliminarContingutFavorit.php?id='.$row['IdContingut'].'&redir=llistarContinguts.php" class="btn btn-success btn-sm" title="Eliminar de favoritos"><i class="bi-star-fill" style="font-size: 0.9rem;"></i></a></center>';
                                                
                                            }  else if (isset($_SESSION['IdContracte'])) { // Imprimim el botó per afegir favorit
                                                echo           '<a href="afegirContingutFavorit.php?id='.$row['IdContingut'].'&redir=llistarContinguts.php" class="btn btn-outline-success btn-sm" title="Agregar a favoritos"><i class="bi-star" style="font-size: 0.9rem;"></i></a></center>';
                                            }  
                                            
                                            //Imprimim els botons per editar i eliminar el contingut
                                            if($_SESSION['administrador']==1){
                                                echo           '<div class="padding"></div>
                                                                <div class="row gap-1">
                                                                <div class="col">
                                                                        <a href="editarContingutForm.php?nomPelicula='.$row['titol'].'" class="btn btn-outline-success btn-sm">
                                                                            <i class="bi-pencil-square" title="Editar contenido" style="font-size: 0.9rem;"></i>
                                                                        </a>
                                                                        <a href="eliminarContingut.php?id='.$row['IdContingut'].'&redir=llistarContinguts.php" onclick="return confirmDelete()" class="btn btn-outline-danger btn-sm">
                                                                            <i class="bi-trash" title="Eliminar contenido"  style="font-size: 0.9rem;"></i>
                                                                        </a> 
                                                                    </div>
                                                                </div>';  
                                            }

                                            // Tancam els div :href="eliminarContingut.php?id='.$row['IdContingut'].'"
                                            echo        '</div>
                                                        </div>
                                                    </div>';
                                        }
                                    }else{ //Si no hi ha coincidencies de cerca
                                        echo '<div class="padding"></div><h6><i class="bi-search" style="font-size: 0.9rem;"></i>&nbsp&nbspNo se han encontrado resultados para la búsqueda</h6><div class="padding"></div>';  
                                    }
                                ?>
                                <div class="padding"></div>
                                <script>

                                </script>
                            </div>
                            </center>  
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <footer>
            PelisTube &copy; 2021
        </footer>

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>