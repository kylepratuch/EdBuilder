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

    //============== Sign up routes =================
    $app->get("/show_sign_up", function() use($app) {
        return $app['twig']->render("sign_up.html.twig", array());
    });

    $app->post("/user_sign_up", function() use($app) {
        $new_user = new User($_POST['username'], $_POST['email'], $_POST['password']);
        $new_user->save();

        return $app['twig']->render("sign_up_confirm.html.twig");
    });

    //=========== Dashboard Routes ================
    $app->get("/show_dashboard/{id}", function($id) use($app) {
        $username = $_GET['username'];
        $user = User::search($username);
        $id = $user->getId();
        $courses = $user->getCourses();

        if($user == NULL) {
            return $app['twig']->render("index.html.twig", array());
        } else {
            return $app['twig']->render("dashboard.html.twig", array(
                'user' => $user,
                'name' => $user->getName(),
                'id' => $user->getId(),
                'courses' => $courses
            ));
        }
    });

    //Add a course
    $app->post("/add_course/{id}", function($id) use($app) {
        $new_course = new Course($_POST['course_title'], $_POST['course_subject'], $_POST['course_description'], $id);
        $new_course->save();

        $user = User::find($id);

        return $app['twig']->render("dashboard.html.twig", array(
            'title' => $new_course->getTitle(),
            'user' => $user,
            'name' => $user->getName(),
            'courses' => $user->getCourses()
        ));
    });

    //Edit user
    $app->get("/show_edit/{id}", function($id) use($app) {
        $user = User::find($id);
        return $app['twig']->render("edit_user.html.twig", array(
            'user' => $user,
        ));
    });

    $app->patch("/show_edit/edit_user/{id}", function($id) use($app) {
        $user = User::find($id);
        $new_name = $_POST['new_name'];
        $new_password = $_POST['new_password'];
        $new_email = $_POST['new_email'];
        $user->updateUser($new_name, $new_email, $password);

        return $app['twig']->render("dashboard.html.twig", array(
            'user' => $user,
            'name' => $user->getName()
        ));
    });

    //============== Course Routes ===============
    $app->get("/show_course/{id}", function($id) use($app) {
        $course = Course::find($id);

        return $app['twig']->render("course.html.twig", array(
            'course' => $course,
            'units' => $course->getUnits()
        ));
    });

    //Add a unit
    $app->post("/add_unit/{id}", function($id) use($app) {
        $new_unit = new Unit($_POST['unit_title'], $_POST['unit_description'], $id);
        $new_unit->save();

        $course = Course::find($id);

        return $app['twig']->render("course.html.twig", array(
            'course' => $course,
            'units' => $course->getUnits()
        ));
    });

    return $app;

?>
