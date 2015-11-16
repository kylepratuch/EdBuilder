<?php

    //Dependencies:
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Lesson.php";
    require_once __DIR__."/../src/Unit.php";
    require_once __DIR__."/../src/User.php";

    //Start new Silex app
    $app = New Silex\Application();
    $app['debug'] = true;

    //Server info goes here:
    $server = 'mysql:host=localhost;dbname=builder_database';
    $username = 'root';
    $password = 'root';

    //Instantiate new PDO
    $DB = new PDO($server, $username, $password);

    //Twig path
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use($app) {
        return $app['twig']->render("index.html.twig", array());
    });

    return $app;

?>
