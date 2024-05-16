<div class="slider-container">
<?php
    if(!$sorteos){
        $sort = <<<EOS
        <div class='slider-item'>
            <a>
                <img src='img/logoFinal.png' alt='imagen del sorteo'>
            </a>
        </div>
        EOS;

        echo $sort;
    }
    foreach ($sorteos as $sorteo) {
        $sort = <<<EOS
        <div class='slider-item'>
            <a href='sorteo.php?id={$sorteo->id}'>
                <img src='{$sorteo->imagen}' alt='imagen del sorteo'>
            </a>
        </div>
        EOS;

        echo $sort;
    }
?>
</div>
