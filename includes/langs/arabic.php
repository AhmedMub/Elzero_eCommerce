<?php

function lang($phrase) {
    static $lang = array(

        'MESSAGE' => 'هلا وسهلا',
        'ADMIN' => 'المدير'
    );

    return $lang[$phrase];
}
