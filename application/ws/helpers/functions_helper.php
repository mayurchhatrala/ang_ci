<?php

function _print_r($arry = array(), $need_exit = FALSE) {
    try {

        if (empty($arry))
            echo 'No Record available. !!';
        else {
            echo '<pre>';
            print_r($arry);
            echo '<pre>';
        }

        if ($need_exit)
            exit;
    } catch (Exception $ex) {
        exit('Error in _print_r function - ' . $ex);
    }
}

function _dump($value, $needExit = FALSE) {
    try {
        var_dump($value);

        if ($needExit)
            exit;
    } catch (Exception $ex) {
        exit('Error in _dump function - ' . $ex);
    }
}

?>
