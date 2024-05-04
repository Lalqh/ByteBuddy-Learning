<?php

class plantillas
{
    public function __construct()
    {
    }

    public function getPlantillaGeneral()
    {
        $html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0879b9;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .item {
            margin-bottom: 10px;
        }
        .item .name {
            font-weight: bold;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <br/><br/>
            <div class="title">Recibo de Compra</div>
            <div class="subtitle">Detalles de la compra:</div>
            <h1>¡Gracias por tu compra!</h1>
        </div>';
        return $html;
    }
}
