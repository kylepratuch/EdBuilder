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

    //=========== User Dashboard Routes ================
    $app->get("/show_dashboard/{id}", function($id) use($app) {
        $username = $_GET['username'];
        $user = User::search($username);
        // $id = $user->getId();
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
            'name' => $user->getName(),
            'courses' => $user->getCourses()
        ));
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

    //============== Course Routes ===============
    $app->get("/show_course/{id}", function($id) use($app) {
        $course = Course::find($id);
        $user_id = $course->getUserId();

        return $app['twig']->render("course.html.twig", array(
            'course' => $course,
            'units' => $course->getUnits(),
            'user' => User::find($user_id)
        ));
    });

    //Edit a course
    $app->get("/show_course_edit/{id}", function($id) use($app) {
        $course = Course::find($id);
        return $app['twig']->render("edit_course.html.twig", array(
            'course' => $course,
        ));
    });

    $app->patch("/show_course_edit/edit_course/{id}", function($id) use($app) {
        $course = Course::find($id);
        $new_title = $_POST['new_title'];
        $new_subject = $_POST['new_subject'];
        $new_description = $_POST['new_description'];
        $course->updateCourse($new_title, $new_subject, $new_description);

        return $app['twig']->render("course.html.twig", array(
            'course' => $course,
            'units' => $course->getUnits()
        ));
    });

    //Delete a course
    $app->get("/delete_course/{user_id}/{course_id}", function($user_id, $course_id) use($app) {
        $course = Course::find($course_id);
        //Deleting a course should also deletes orphaned units
        $units = $course->getUnits();
        foreach($units as $unit) {
            $unit->delete();
        }
        $course->delete();

        return $app['twig']->render("dashboard.html.twig", array(
            'user' => User::find($user_id),
            'courses' => $courses
        ));
    });

    //Add a unit
    $app->post("/add_unit/{user_id}/{course_id}", function($user_id, $course_id) use($app) {
        $new_unit = new Unit($_POST['unit_title'], $_POST['unit_description'], $course_id);
        $new_unit->save();

        $course = Course::find($course_id);

        return $app['twig']->render("course.html.twig", array(
            'course' => $course,
            'units' => $course->getUnits(),
            'user' => User::find($user_id)
        ));
    });

    //================= Unit Routes =================
    //Show unit
    $app->get("/show_unit/{id}", function($id) use($app) {
        $unit = Unit::find($id);
        $course_id = $unit->getCourseId();

        return $app['twig']->render("unit.html.twig", array(
            'unit' => $unit,
            'lessons' => $unit->getLessons(),
            'course' => Course::find($course_id)
        ));
    });

    //Edit a unit
    $app->get("/show_unit_edit/{id}", function($id) use($app) {
        $unit = Unit::find($id);
        return $app['twig']->render("edit_unit.html.twig", array(
            'unit' => $unit,
        ));
    });

    $app->patch("/show_unit_edit/edit_unit/{id}", function($id) use($app) {
        $unit = Unit::find($id);
        $new_title = $_POST['new_title'];
        $new_description = $_POST['new_description'];
        $unit->updateUnit($new_title, $new_description);

        $course_id = $unit->getCourseId();

        return $app['twig']->render("unit.html.twig", array(
            'unit' => $unit,
            'lessons' => $unit->getLessons(),
            'course' => Course::find($course_id)
        ));
    });

    //Delete a unit
    $app->get("/delete_unit/{course_id}/{unit_id}", function($course_id, $unit_id) use($app) {
        $unit = Unit::find($unit_id);
        $course = Course::find($course_id);

        //Deleting a unit should also deletes orphaned units
        $lessons = $unit->getLessons();
        foreach($lessons as $lesson) {
            $lesson->delete();
        }
        $unit->delete();
        
        $user_id = $course->getUserId();

        return $app['twig']->render("course.html.twig", array(
            'course' => Course::find($course_id),
            'units' => $units,
            'user' => User::find($user_id)

        ));
    });

    //Add a lesson

    //================= Lesson Routes ===============
    //Show lesson

    //Edit a lesson

    //Delete a lesson

    return $app;

?>
