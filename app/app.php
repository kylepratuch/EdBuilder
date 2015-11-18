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

    //Basic get Calls
    $app->get("/", function() use($app) {
        return $app['twig']->render("index.html.twig", array());
    });

    $app->get("/sign_up", function() use($app) {
        return $app['twig']->render("sign_up.html.twig", array());
    });

    $app->get("/about", function() use($app) {
        return $app['twig']->render("about.html.twig", array());
    });

    //Get Login call
    $app->get("/login", function() use($app) {
        $username = $_GET['username'];
        $user = User::search($username);

        if($user == NULL) {
            return $app['twig']->render("index.html.twig", array());
        } else {
            return $app['twig']->render("courses.html.twig", array());
        }
    });

    //Sign up routes
    $app->get("/show_sign_up", function() use($app) {
        return $app['twig']->render("sign_up.html.twig", array());
    });

    $app->post("/user_sign_up", function() use($app) {
        return $app['twig']->render("sign_up_confirm.html.twig", array());
        $new_user = new User($_POST['username'], $_POST['email'], $_POST['password']);
        $new_user->save();

        return $app['twig']->render("sign_up_confirm.html.twig");
    });

    return $app;

?>
