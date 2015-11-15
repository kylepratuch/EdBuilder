<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/User.php";
require_once "src/Course.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class UserTest extends PHPUnit_Framework_TestCase
{
    // Clear test database on each test run
    protected function tearDown()
    {
        User::deleteAll();
        Course::deleteAll();
    }

    // Test our CRUD:
    function testSave()
    {
        //Arrange
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);

        //Act
        $test_user->save();
        $result = User::getAll();

        //Assert
        $this->assertEquals($test_user, $result[0]);
    }

    function testDelete()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";
        $signed_in2 = 0;
        $test_user2 = new User($name2, $password2, $email2, $signed_in2);
        $test_user2->save();

        $test_user->delete();
        $result = User::getAll();

        $this->assertEquals([$test_user2], $result);

    }

    function testUpdateUser()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";

        $test_user->updateUser($name2, $password2, $email2);
        $result = User::getAll();

        $this->assertEquals($test_user, $result[0]);
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

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";
        $signed_in2 = 0;
        $test_user2 = new User($name2, $password2, $email2, $signed_in2);
        $test_user2->save();

        $result = User::find($test_user->getId());

        $this->assertEquals($test_user, $result);
    }

    //Test getCourses function
    function testGetCourses()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";
        $signed_in2 = 0;
        $test_user2 = new User($name2, $password2, $email2, $signed_in2);
        $test_user2->save();

        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($title, $subject, $description, $user_id);
        $test_course->save();

        $title2 = "Algebra";
        $subject2 = "Math";
        $description2 = "Introduction to algebraic equations.";
        $user_id2 = $test_user2->getId();
        $test_course2 = new Course($title2, $subject2, $description2, $user_id2);
        $test_course2->save();

        $result = $test_user->getCourses();

        $this->assertEquals($test_course, $result[0]);
    }
}

?>
