<?php

function flash($key, $value)
{
    if (!is_array($_SESSION['__FLASH__'])) {
        $_SESSION['__FLASH__'] = [];
    }

    $_SESSION['__FLASH__'][$key] = $value;
}

function unflash($key, $default = null)
{
    // if (isset($_SESSION['__FLASH__'][$key])) {
    //     $value = $_SESSION['__FLASH__'][$key];
    // } else {
    //     $value = $default;
    // }
    $value = $_SESSION['__FLASH__'][$key] ?? $default;
    unset($_SESSION['__FLASH__'][$key]);
    return $value;
}

function debug($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

function dd($value)
{
    debug($value);
    die();
}

function formatDate($format = "Y-m-d H:i:s", $date)
{
    $date = new DateTime($date);
    return $date->format($format);
}
