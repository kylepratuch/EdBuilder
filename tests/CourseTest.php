<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Course.php";

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
    }

    //Test save and getAll functions
    function testSave()
    {
        //Arrange
        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $test_course = new Course($title, $subject, $description);

        //Act
        $test_course->save();
        $result = Course::getAll();

        //Assert
        $this->assertEquals($test_course, $result[0]);
    }

    function testDelete()
    {
        $title = "Literature";
        $subject = "English";
        $description = "Deconstructing English literature.";
        $test_course = new Course($title, $subject, $description);
        $test_course->save();

        $title2 = "Algebra";
        $subject2 = "Math";
        $description2 = "Introduction to algebraic equations.";
        $test_course2 = new Course($title2, $subject2, $description2);
        $test_course2->save();

        $test_course->delete();
        $result = Course::getAll();

        $this->assertEquals([$test_course2], $result);
    }
}

?>
