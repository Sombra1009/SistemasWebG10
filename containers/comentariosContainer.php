<h2 class="containerTittle">Comentarios</h2>
<div class="comentariosContainer">
    <?php
    $comentarios = Comentario::getComentarios($id);
    foreach ($comentarios as $comentario) {
        $usuario = Usuario::getUsuarioPorId($comentario->idUsuario);
        $check1 = "";
        $check2 = "";
        $check3 = "";
        $check4 = "";
        $check5 = "";
        if($comentario->valoracion == 1){
            $check1 = "checked";
        }else if($comentario->valoracion == 2){
            $check2 = "checked";
        }else if($comentario->valoracion == 3){
            $check3 = "checked";
        }else if($comentario->valoracion == 4){
            $check4 = "checked";
        }else if($comentario->valoracion == 5){
            $check5 = "checked";
        }

        $html = <<<EOF
        <div class="comentario">
            <div class="user">
                <h2>{$usuario->username}</h2>
                <p>{$comentario->fecha}</p>
            </div>
            <div class="contenido">
                <p>{$comentario->contenido}</p>
            </div>
            <div class="valoracion">
                <form>
                <div class="rating">
                        <input type='radio' hidden name='rate' id='rating_5' value="5" data-idx='0' {$check5} disabled>	
                        <label for='rating_5'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_4' value="4" data-idx='1' {$check4} disabled>
                        <label for='rating_4'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_3' value="3" data-idx='2' {$check3} disabled>
                        <label for='rating_3'></label>
                
                        <input type='radio' hidden name='rate' id='rating_2' value="2" data-idx='3' {$check2} disabled>
                        <label for='rating_2'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_1' value="1" data-idx='4' {$check1} disabled>
                        <label for='rating_1'></label>
                    </div>
                </form>
            </div>
        </div>
EOF;
        echo $html;
    }
    ?>
</div>