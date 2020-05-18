<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once("vendor/autoload.php");
require_once("model/data-layer.php");

// Start a session AFTER requiring autoload.php
session_start();

// Instantiate the F3 Base Class
$f3 = Base::instance();
$validator = new Validate();
$controller = new Controller($f3);

// Default route
$f3->route('GET /', function()
{
    $GLOBALS['controller']->home();
});

// Default route to Orders
$f3->route('GET|POST /order', function()
{
    $GLOBALS['controller']->order();
});

// Breakfast route
$f3->route('GET /breakfast', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/bfast.html');
});

// Breakfast - green eggs & ham route
$f3->route('GET /breakfast/green-eggs', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/greenEggsAndHam.html');
});

// Breakfast - Cereals
$f3->route('GET /breakfast/cereal', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/cereal.html');
});

// Condiments route
$f3->route('GET|POST /condiments', function($f3)
{
    $GLOBALS['controller']->order2();
});

// Breakfast route
$f3->route('GET /summary', function()
{
    //echo '<h1>Thank you for your order!</h1>';

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

// Run F3
$f3->run();

