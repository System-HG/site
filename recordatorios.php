<?php
// ⏰ EJECUTAR TODOS LOS DÍAS A LAS 8:00 AM
require "config/sesion.php";
require "config/bd.php";
$config_whatsapp = require "config/whatsapp.php";

require_once __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

function enviarWhatsAppAPI($telefono, $mensaje, $config) {
    $num = preg_replace('/[^0-9]/', '', $telefono);
    if (strlen($num) === 10 && $num[0] === '0') $num = '593' . substr($num, 1);
    elseif (strlen($num) === 9) $num = '593' . $num