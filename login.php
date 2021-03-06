<?php session_start();
    if(!isset($_SESSION['username'])){
        // Recollida de paràmetres del formulari
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Connexió a bd
        include "connection.php";
        $query = "SELECT * FROM persona WHERE username='".$username."'";
        $result=mysqli_query($con, $query); 
        $row = mysqli_fetch_array($result);

        if (!isset($row['username'])){
            header("Location: index.php?msg=15");
            die();
        }

        $passbd = $row['password']; // Conté la contrasenya encriptada emmegatzemada a la base de dades

        if(!password_verify($password, $passbd)){ // Compara la contrasenya introduïda (plain) amb la guardada a la base de dades (encriptada)
            header("Location: index.php?msg=16");
            die();
            
        }

        $_SESSION['username']= $username; // Establim la variable de sessió (username)
        $_SESSION['administrador']=$row['administrador']; // Si es administrador o no (administrador)
        $_SESSION['IdTipus']=$row['IdTipus']; // El tipus de l'usuari

        $query = "SELECT * FROM contracte WHERE username='".$_SESSION['username']."'" ; // Cerc el contracte de l'usuari per tenir-lo com a variable de sessió
        $result = mysqli_query($con,$query);
        $row= mysqli_fetch_array($result);

        // Es fa així amb IdContracte, perquè si no pot donar errors en cas de que no hi hagi contractes actius
        if(isset($row['IdContracte'])){
            $_SESSION['IdContracte']=$row['IdContracte'];
            $_SESSION['estatContracte']=$row['estat'];
        } else {
            $_SESSION['IdContracte']=null;
            $_SESSION['estatContracte']=null;
        }

        mysqli_close($con);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Iconos bootstrap -->
    <link rel="shortcut icon" href="img/icon.png" /> <!-- Icono de la pestaña-->
    <script language="JavaScript" type="text/javascript" src="scripts.js"></script> <!-- Para importar mi hoja de scripts propia -->
    
</head>
    <body>
        <header>
            <?php include "navbar.php"; include "missatge.php" ?>
        </header>

        <section>
        <div class="padding"></div>
            <div class="container">
                <div class="row ">
                    <div class="col-md-1"></div> 
                    <div class="col-md-10">
                        <div class="shadow-lg p-4 mb-5 bg-body rounded">
                                <div class="row gap-2">
                                    <!-- *********************************************************** MISSATGES *********************************************************** -->
                                    <!-- Mostra el número total de missatges pendents de llegir i el darrer missatge rebut -->
                                    <div class="col"> 
                                        <h5>Bandeja de entrada</h5>
                                        <div class="padding"></div>
                                        <center>
                                        <div class="card">
                                            <div class="card-body">
                                                <?php
                                                    include "connection.php";

                                                    $query = "SELECT count(*) from missatge where username='".$_SESSION['username']."' and estatMissatge=0";
                                                    $result = mysqli_query($con,$query);
                                                    $row = mysqli_fetch_array($result);

                                                    if($row['count(*)']>0){
                                                        echo '<img src="img/envelope-exclamation.svg" height="30" width="30"><div class="padding"></div>';
                                                        echo '<h6>Tienes '.$row['count(*)']." mensaje(s) nuevos:</h6>";
                                                        $query = "SELECT * from missatge where username='".$_SESSION['username']."'";
                                                        $result = mysqli_query($con,$query);
                                                        
                                                        $row = mysqli_fetch_array($result); // Obtenim la primera fila de la consulta
                                                        echo $row['data']." - ".$row['assumpte']."<br>"; 
                                                        
                                                        echo '<div class="padding"></div><a href="llistarMissatges.php?orden=noAbiertos" class="btn btn-danger btn-sm">Ver más</a>';
                                                    } else {
                                                        echo '<img src="img/envelope.svg" height="30" width="30"><div class="padding"></div>';
                                                        echo "<h6>No tienes mensajes nuevos</h6>";
                                                    }
                                                    mysqli_close($con);
                                                ?>
                                            </div>
                                        </div>
                                        </center>
                                    </div>
                                    <!-- *********************************************************** FACTURES *********************************************************** -->
                                    <!-- Mostrarà la factura més antiga sense pagar (només 1 sempre), mentres n'hi hagi sense pagar. Si no, mostrarà la més recent per a 
                                         la seva consulta  -->
                                    <div class="col">
                                        <h5>Facturación</h5>
                                        <div class="padding"></div>
                                        <center>
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="img/cash-stack.svg" height="30" width="30" style="color: white">
                                                <div class="padding"></div>
                                                <?php
                                                    include "connection.php";

                                                    $query = "SELECT * FROM factura WHERE idContracte='".$_SESSION['IdContracte']."' and dataPagament is null";
                                                    $result = mysqli_query($con,$query);
                                                    if($row = mysqli_fetch_array($result)){
                                                        echo '<h6>Consulta tu última factura:</h6>';
                                                        echo $row['dataInici']." al ".$row['dataFinal']." - Importe: ".$row['import'].'€';
                                                        echo '<div class="padding"></div><a href="veureFacturesNoPagades.php" class="btn btn-danger btn-sm">Pagar</a>';
                                                        
                                                    } else {
                                                        $query = "SELECT * FROM factura WHERE idContracte='".$_SESSION['IdContracte']."' and dataPagament is not null ORDER BY dataFinal DESC";
                                                        $result = mysqli_query($con,$query);

                                                        if($row = mysqli_fetch_array($result)){
                                                            echo '<h6>Consulta tu última factura:</h6>';
                                                            echo $row['dataInici']." al ".$row['dataFinal']." - Importe: ".$row['import'].'€';
                                                            echo '<div class="padding"></div><a href="veureFactures.php" class="btn btn-danger btn-sm">Consultar</a>';
                                                        } else {
                                                            echo '<h6>No tienes todavía ninguna factura disponible</h6>'; 
                                                        }
                                                    }
                                                    mysqli_close($con);
                                                ?>
                                                    
                                            </div>
                                        </div>
                                        </center>
                                    </div>
                                    <div class="padding"></div>
                                    <!-- ************************************************ SISTEMA DE RECOMANACIÓ ************************************************
                                        1. Es mostren continguts segons els missatges rebuts i no llegits pels usuaris (recordem que els missatges van associats
                                    a un nou contingut que s'acaba de pujar a la plataforma). Així doncs, si l'usuari té pel·lícules noves per veure (missatges)
                                    li surtiran tants de continguts com missatges associats a cada un d'ells tengui, fins a un màxim de 16 ($mas_recommend). En
                                    aquest cas, no es tendrà en compte si el contingut es recomanable pel tipus d'usuari segons l'edat.

                                        2. Si un usuari no té missatges pendents de llegir o en té menys de 12, es llistaran continguts de forma aleatòria de les
                                    categories favorites de l'usuari fins al màxim de 16 continguts (sense que es repeteixi cap contingut). En cas de no tenir cap
                                    categoria favorita es mostrarà un missatge indicant-li a l'usuari que afegueixi alguna categoria com a favorita per començar a
                                    rebre recomanacions. En aquest cas sí es tendrà en compte si el contingut és recomanable pel tipus d'usuari segons l'edat
                                    d'aquest i la edat destinada del contingut en concret (taula r_tipus_contingut)

                                        3. Impressió dels continguts recomanats
                                
                                    ACLARACIONS CODI:   - Classe contingut per emmagatzemar les pel·lícules
                                                        - Tots els continguts a recomanar es ficaran dins $movies, que serà un array d'objectes contingut. Això ens permet
                                                          obtenir un algorisme més senzill gràcies a les operacions shuffle (que mesclarà tot l'array, per obtenir resultats
                                                          diferents cada vegada que recarreguem la pàgina) i in_array (que comprova si un objecte ja existeix )
                                                        - El nombre màxim de continguts mostrats serà de $max_recomend -->
                                    <h5>Recomendaciones </h5>
                                    <center>
                                    <div class="row justify-content-center gap-2"> 
                                        <?php 
                                            // Classe contingut
                                            class contingut{
                                                public $titol;
                                                public $cami;
                                                public $id; 

                                                public function __construct($titol, $cami, $id){
                                                    $this->titol = $titol;
                                                    $this->cami = $cami;
                                                    $this->id = $id;
                                                }
                                            }

                                            $movies=array(); // Array de continguts
                                            $max_recommend=16; // Número màxim de continguts a recomanar

                                            // 1. SEGONS MISSATGES (no es té en compte l'edat)
                                            include "connection.php";
                                            $query = "SELECT * from missatge where username='".$_SESSION['username']."' and estatMissatge=0" ; // Missatges d'usuari no llegits
                                            $result = mysqli_query($con,$query);
                        
                                            $i=0;
                                            if($row=mysqli_fetch_array($result)){
                                                while (isset($row) and $i<$max_recommend){ 
                                                    $query = "SELECT * from contingut where IdContingut='".$row['IdContingut']."'"; // Agafam el contingut de cada missatge
                                                    $result2 = mysqli_query($con,$query);
                                                    $contingut = mysqli_fetch_array($result2);
                                                    
                                                    $c=new contingut($contingut['titol'], $contingut['camiFoto'], $contingut['IdContingut']); // el guardo a l'array
                                                    array_push($movies, $c);

                                                    $row=mysqli_fetch_array($result);
                                                    $i=$i+1;
                                                }
                                            }
                                            
                                            // 2. SEGONS CATEGORIES FAVORITES i CONTINGUT ADIENT (r_tipus_contingut/edat recomanada del contingut)
                                            $query = "SELECT count(*) from categoriafavorits where IdContracte='".$_SESSION['IdContracte']."'" ; // Calculam el nombre de categories favorites del usuari
                                            $result = mysqli_query($con,$query);
                                            $row = mysqli_fetch_array($result);

                                            $nFalta=$max_recommend-$i; // Pel·lícules que falten per mostrar el màxim de 8 pel·lícules al login
                                            $nCategories= $row['count(*)']; // num de categories favorites de l'usuari

                                            if($nCategories>0){ 
                                                // De tots els continguts només seleccionam els visibles
                                                $query = "SELECT * from categoriafavorits join contingut on contingut.nomCat=categoriafavorits.nomCat and categoriafavorits.IdContracte=".$_SESSION['IdContracte']." and contingut.visible=1 ORDER BY RAND();" ; // ordenat aleatòriament
                                                $result = mysqli_query($con,$query);
                                                                                                                                            
                                                $it=0;
                                                while($contingut = mysqli_fetch_array($result) and $it<$nFalta){ // Sempre que hi hagi continguts a la taula i encara no haguem cobert el $max_recommend
                                                    $c=new contingut($contingut['titol'], $contingut['camiFoto'], $contingut['IdContingut']);
                                                    if(!in_array($c,$movies)){ // Si és un contingut que ja es troba dins l'array, no l'afegirem a l'array i no iterarem (seguirem cercant)
                                                        switch ($_SESSION['IdTipus']) { // 3 possibilitats
                                                            case 1: // menor de 9 anys --> només recomanam els continguts de la seva edat
                                                                $query2 = "SELECT * from r_tipus_contingut where IdContingut=".$contingut['IdContingut']." and IdTipus=1"; // Miram si el contingut és de la meva edat
                                                                break;

                                                            case 2: // 9-18 anys --> recomanam els continguts de la seva edat i inferiors
                                                                $query2 = "SELECT * from r_tipus_contingut where IdContingut=".$contingut['IdContingut']." and IdTipus!=3"; // Miram si el contingut es per majors de 18 anys
                                                                break;

                                                            default: // per al cas 3 i possibles nous casos no tenguts en compte per defecte --> qualsevol contingut és recomanable
                                                                $query2 = "SELECT * from r_tipus_contingut where IdContingut=".$contingut['IdContingut']; // Miram si el contingut es per majors de 18 anys
                                                                break;
                                                        }

                                                        $result2 = mysqli_query($con,$query2);
                                                        $tipusContingut=mysqli_fetch_array($result2);

                                                        if (isset($tipusContingut['IdContingut'])){ 
                                                            array_push($movies, $c);
                                                            $it=$it+1;
                                                        }                                                        
                                                    } 
                                                }
                                            }

                                            // 3. IMPRESSIÓ DELS CONTINGUTS RECOMANATS
                                            $length=count($movies);
                                            if (count($movies)>0){ // Hi ha pel·lícules per recomanar
                                                shuffle($movies); // Es mesclen els continguts per mostrar-se de forma aleatòria
                                                $it=0;
                                                while ($it<$length){
                                                    $query2 = "SELECT * FROM contingutfavorits WHERE IdContracte=".$_SESSION['IdContracte']." and IdContingut=".$movies[$it]->id."";
                                                    $result2 = mysqli_query($con,$query2);
                                                    $fav = mysqli_fetch_array($result2);
                                                    echo   '<div class="col">
                                                                <div class="card" style="width: 12rem;">
                                                                    <img class="card-img-top" src=".'.$movies[$it]->cami.'" alt="'.$movies[$it]->titol.'.png" height="250">
                                                                    <div class="card-body">
                                                                        <h6>'.$movies[$it]->titol.'</h6>
                                                                        <div class="padding"></div>
                                                                        <a href="veureContingut.php?id='.$movies[$it]->id.'" class="btn btn-danger btn-sm">Ver película</a> ';

                                                    if($_SESSION['administrador']==1){
                                                        echo           '<a href="eliminarContingut.php?id='.$movies[$it]->id.'&redir=login.php" class="btn btn-outline-danger btn-sm"><i class="bi-star-fill" title="Eliminar de favoritos" style="font-size: 0.9rem;"></i></a>';              
                                                    }

                                                    if(isset($fav)){ // Imprimim el botó per eliminar favorit
                                                        echo           '<a href="eliminarContingutFavorit.php?id='.$movies[$it]->id.'&redir=login.php" class="btn btn-success btn-sm"><i class="bi-star-fill" title="Eliminar de favoritos" style="font-size: 0.9rem;"></i></a>';
                                                                    
                                                                            
                                                    }  else { // Imprimim el botó per afegir favorit
                                                        echo            '<a href="afegirContingutFavorit.php?id='.$movies[$it]->id.'&redir=login.php" class="btn btn-outline-success btn-sm"><i class="bi-star" title="Agregar a favoritos" style="font-size: 0.9rem;"></i></a>';
                                                                    
                                                    }
                                                    
                                                    echo            '</div>
                                                                </div>
                                                            </div>';

                                                    $it=$it+1;
                                                }

                                            } else { // Si no hem trobat cap pel·licula per recomanar, és perque l'usuari encara no ha afegit categories favorites
                                                echo '<div class="padding"></div><h6><img src="img/tags.svg" height="15" width="15" style="color: white">&nbsp&nbspAñade categorías favoritas para empezar a recibir recomendaciones</h6><div class="padding"></div>';  
                                            }

                                            mysqli_close($con);
                                        ?> 
                                    </div>
                                </center>
                            </div>
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
