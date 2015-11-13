<?php

    class Course
    {
        private $title;
        private $subject;
        private $description;
        private $id;


        function __construct($title, $subject, $description, $id = null)
        {
            $this->title = $title;
            $this->subject = $subject;
            $this->description = $description;
            $this->id = $id;
        }

        //$title setter and getter
        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        //$subject setter and getter
        function setSubject()
        {
            $this->subject = (string) $new_subject;
        }

        function getSubject()
        {
            return $this->subject;
        }

        //$description setter and getter
        function setDescription()
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        //Save a course to the database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (title, subject, description) VALUES
                ('{$this->getTitle()}',
                 '{$this->getSubject()}',
                 '{$this->getDescription()}');
            ");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Delete a single course
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

        //Delete ALL courses
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        //Get all courses in table
        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach ($returned_courses as $course) {
                $title          = $course['title'];
                $subject        = $course['subject'];
                $description    = $course['description'];
                $id             = $course['id'];

                $new_course = new Course($title, $subject, $description, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }
    }
?>
