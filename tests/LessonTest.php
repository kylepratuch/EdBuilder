<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Lesson.php";
require_once "src/Unit.php";
require_once "src/Course.php";
require_once "src/User.php";

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
        $test_unit->save();

        $lesson_title = "Into the Wild: Chapter 1";
        $objective = "Students will read and discuss Chapter 1";
        $materials = "Books, discussion packets, pencils";
        $body = "Lorem ipsum etc etc blah blah blah blah...";
        $unit_id = $test_unit->getId();
        $test_lesson = new Lesson($lesson_title, $objective, $materials, $body, $unit_id);

        //Act
        $test_lesson->save();
        $result = Lesson::getAll();

        //Assert
        $this->assertEquals($test_lesson, $result[0]);
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

        $lesson_title = "Into the Wild: Chapter 1";
        $objective = "Students will read and discuss Chapter 1";
        $materials = "Books, discussion packets, pencils";
        $body = "Lorem ipsum etc etc blah blah blah blah...";
        $unit_id = $test_unit->getId();
        $test_lesson = new Lesson($lesson_title, $objective, $materials, $body, $unit_id);
        $test_lesson->save();

        $lesson_title2 = "The Catcher in the Rye: Chapter 3";
        $objective2 = "Students will read and discuss Chapter 3";
        $materials2 = "Books, essay prompts, pens";
        $body2 = "Blah blah blah etc etc lorem ipsum...";
        $test_lesson2 = new Lesson($lesson_title2, $objective2, $materials2, $body, $unit_id);
        $test_lesson2->save();

        $test_lesson->delete();
        $result = Lesson::getAll();

        $this->assertEquals([$test_lesson2], $result);
    }

    function testUpdateLesson()
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

        $lesson_title = "Into the Wild: Chapter 1";
        $objective = "Students will read and discuss Chapter 1";
        $materials = "Books, discussion packets, pencils";
        $body = "Lorem ipsum etc etc blah blah blah blah...";
        $unit_id = $test_unit->getId();
        $test_lesson = new Lesson($lesson_title, $objective, $materials, $body, $unit_id);
        $test_lesson->save();

        $lesson_title2 = "The Catcher in the Rye: Chapter 3";
        $objective2 = "Students will read and discuss Chapter 3";
        $materials2 = "Books, essay prompts, pens";
        $body2 = "Blah blah blah etc etc lorem ipsum...";

        $test_lesson->updateLesson($lesson_title2, $objective2, $materials2, $body2);
        $result = Lesson::getAll();

        $this->assertEquals($test_lesson, $result[0]);
    }

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

        $lesson_title = "Into the Wild: Chapter 1";
        $objective = "Students will read and discuss Chapter 1";
        $materials = "Books, discussion packets, pencils";
        $body = "Lorem ipsum etc etc blah blah blah blah...";
        $unit_id = $test_unit->getId();
        $test_lesson = new Lesson($lesson_title, $objective, $materials, $body, $unit_id);
        $test_lesson->save();

        $lesson_title2 = "The Catcher in the Rye: Chapter 3";
        $objective2 = "Students will read and discuss Chapter 3";
        $materials2 = "Books, essay prompts, pens";
        $body2 = "Blah blah blah etc etc lorem ipsum...";
        $test_lesson2 = new Lesson($lesson_title2, $objective2, $materials2, $body, $unit_id);
        $test_lesson2->save();

        $result = Lesson::find($test_lesson->getId());

        $this->assertEquals($test_lesson, $result);
    }
}

?>
