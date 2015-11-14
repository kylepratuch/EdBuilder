<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Course.php";
require_once "src/User.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class CourseTest extends PHPUnit_Framework_TestCase
{
    //Clear test database on each test run
    protected function tearDown()
    {
        Course::deleteAll();
        User::deleteAll();
    }

    //Test our CRUD:
    function testSave()
    {
        //Arrange
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($title, $subject, $description, $user_id);

        //Act
        $test_course->save();
        $result = Course::getAll();

        //Assert
        $this->assertEquals($test_course, $result[0]);
    }

    function testDelete()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($title, $subject, $description, $user_id);

        $title2 = "Algebra";
        $subject2 = "Math";
        $description2 = "Introduction to algebraic equations.";
        $test_course2 = new Course($title2, $subject2, $description2, $user_id);
        $test_course2->save();

        $test_course->delete();
        $result = Course::getAll();

        $this->assertEquals([$test_course2], $result);
    }

    function testUpdateCourse()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($title, $subject, $description, $user_id);
        $test_course->save();

        $title2 = "Algebra";
        $subject2 = "Math";
        $description2 = "Introduction to algebraic equations.";

        $test_course->updateCourse($title2, $subject2, $description2);
        $result = Course::getAll();

        $this->assertEquals($test_course, $result[0]);
    }

    //Test find function
    function testFind()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($title, $subject, $description, $user_id);
        $test_course->save();

        $title2 = "Algebra";
        $subject2 = "Math";
        $description2 = "Introduction to algebraic equations.";
        $test_course2 = new Course($title2, $subject2, $description2, $user_id);
        $test_course2->save();

        $result = Course::find($test_course->getId());

        $this->assertEquals($test_course, $result);
    }
}

?>
