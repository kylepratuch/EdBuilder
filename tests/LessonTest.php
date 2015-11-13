<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Lesson.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class LessonTest extends PHPUnit_Framework_TestCase
{
    //Clear test database on each test run
    protected function tearDown()
    {
        Lesson::deleteAll();
    }

    //Test our CRUD:
    function testSave()
    {
        //Arrange
        $title = "Into the Wild: Chapter 1";
        $objective = "Students will read and discuss Chapter 1";
        $materials = "Books, discussion packets, pencils";
        $body = "Lorem ipsum etc etc blah blah blah blah...";
        $test_lesson = new Lesson($title, $objective, $materials, $body);

        //Act
        $test_lesson->save();
        $result = Lesson::getAll();

        //Assert
        $this->assertEquals($test_lesson, $result[0]);
    }
    
}

?>
