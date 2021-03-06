<?php
if(isset($_GET['msg'])){
    echo '<div class="padding"></div>';
    switch($_GET['msg']){
        case 1: // Eliminació contingut
            echo    '</div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-trash" style="font-size: 0.9rem;"></i>
                        &nbspContenido eliminado correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        case 2: // Edició contingut
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                        &nbspContenido editado correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 3: // Addició contingut
            echo    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="bi-plus-circle" style="font-size: 0.9rem;"></i>
                        &nbspContenido añadido correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
    
        case 4: // Edició categoria
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                        &nbspCategoría editada correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 5: // Addició categoria
            echo    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="bi-tags" style="font-size: 0.9rem;"></i>
                        &nbspCategoría añadida correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                break;
                
        case 6: // Eliminació categoria favorita
            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspCategoría favorita eliminada correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        case 7: // Addició categoria favorita
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspCategoria favorita añadida correctamente
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
            
        case 8: // Addició contingut favorit
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspContenido favorito añadido correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 9: // Eliminació contingut favorita
            echo    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-star" style="font-size: 0.9rem;"></i>
                        &nbspContenido favorito eliminado correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 10: // Restaurar contingut
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-cloud-download" style="font-size: 0.9rem;"></i>
                        &nbspContenido restaurado correctamente
                        <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;
        
        case 11: // Creació contracte
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                            &nbspContrato creado correctamente
                            <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
            break;

        case 12: // Edició contracte
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                            &nbspContrato editado correctamente
                            <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
            break;

        case 13: // Pagar
            echo    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi-check2-square" style="font-size: 0.9rem;"></i>
                            &nbspPagado correctamente
                            <button type="button" style="background-color: transparent; border: 0px; class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
            break;

        case 14: // Contingut no visible
            echo    '</div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-square-fill" style="font-size: 0.9rem;"></i>
                        &nbspContenido no visible
                        <button type="button" style="background-color: transparent; border: 0px;" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            break;

        case 15: // Inicio de sessió: Usuari inexistent
            echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                        &nbspEl username introducido no existe
                     </div>';
            break;

        case 16: // Inici de sessió: Contrasenya incorrecta
            echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                        &nbspContraseña incorrecta
                    </div>';
            break;

        case 17: // Registre satisfactori
            echo    '<div class="padding"></div><div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                            &nbspTe has registrado satisfactoriamente
                        </div>';
            break;

        case 18: // Registre: Contrassenyes no coincideixen
            echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                        &nbspLas contraseñas no coinciden
                        </div>';
            break;
        case 19: // Registre: Username ja en ús
            echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-person-x" style="font-size: 0.9rem;"></i>
                        &nbspEl nombre de usuario elegido ya existe
                    </div>';
            break;
        
        case 20: // Restaurar un contingut d'una categoria invisible
            echo    '<div class="padding"></div><div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi-exclamation-circle" style="font-size: 0.9rem;"></i>
                        &nbspAtención! Acabas de restaurar un contenido de una categoría no visible. Cambia la categoria del contenido restaurado
                        inmediatamente para que pueda ser encontrado fácilmente
                    </div>';
            break;
                
        default: 
    }
}
?>