<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Unit.php";
require_once "src/Course.php";
require_once "src/User.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class UnitTest extends PHPUnit_Framework_TestCase
{
    //Clear test database on each test run
    protected function tearDown()
    {
        Unit::deleteAll();
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

        $course_title = "Literature";
        $subject = "English";
        $course_description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($course_title, $subject, $course_description, $user_id);
        $test_course->save();

        $unit_title = "Into the Wild";
        $unit_description = "The life and death of Chris McCandless.";
        $course_id = $test_course->getId();
        $test_unit = new Unit($unit_title, $unit_description, $course_id);

        //Act
        $test_unit->save();
        $result = Unit::getAll();

        //Assert
        $this->assertEquals($test_unit, $result[0]);
    }

    function testDelete()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $course_title = "Literature";
        $subject = "English";
        $course_description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($course_title, $subject, $course_description, $user_id);
        $test_course->save();

        $unit_title = "Into the Wild";
        $unit_description = "The life and death of Chris McCandless.";
        $course_id = $test_course->getId();
        $test_unit = new Unit($unit_title, $unit_description, $course_id);
        $test_unit->save();

        $unit_title2 = "The Catcher in the Rye";
        $unit_description2 = "Foul-mouthed kid is angsty.";
        $test_unit2 = new Unit($unit_title2, $unit_description2, $course_id);
        $test_unit2->save();

        $test_unit->delete();
        $result = Unit::getAll();

        $this->assertEquals([$test_unit2], $result);
    }

    function testUpdateUnit()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $course_title = "Literature";
        $subject = "English";
        $course_description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($course_title, $subject, $course_description, $user_id);
        $test_course->save();

        $unit_title = "Into the Wild";
        $unit_description = "The life and death of Chris McCandless.";
        $course_id = $test_course->getId();
        $test_unit = new Unit($unit_title, $unit_description, $course_id);
        $test_unit->save();

        $unit_title2 = "The Catcher in the Rye";
        $unit_description2 = "Foul-mouthed kid is angsty.";

        $test_unit->updateUnit($unit_title2, $unit_description2);
        $result = Unit::getAll();

        $this->assertEquals($test_unit, $result[0]);
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

        $course_title = "Literature";
        $subject = "English";
        $course_description = "Deconstructing English literature.";
        $user_id = $test_user->getId();
        $test_course = new Course($course_title, $subject, $course_description, $user_id);
        $test_course->save();

        $unit_title = "Into the Wild";
        $unit_description = "The life and death of Chris McCandless.";
        $course_id = $test_course->getId();
        $test_unit = new Unit($unit_title, $unit_description, $course_id);
        $test_unit->save();

        $unit_title2 = "The Catcher in the Rye";
        $unit_description2 = "Foul-mouthed kid is angsty.";
        $test_unit2 = new Unit($unit_title2, $unit_description2, $course_id);
        $test_unit2->save();

        $result = Unit::find($test_unit->getId());

        $this->assertEquals($test_unit, $result);
    }
}

?>
