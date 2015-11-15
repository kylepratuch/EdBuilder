<?php

    class Course
    {
        private $title;
        private $subject;
        private $description;
        private $user_id;
        private $id;


        function __construct($title, $subject, $description, $user_id, $id = null)
        {
            $this->title = $title;
            $this->subject = $subject;
            $this->description = $description;
            $this->user_id = $user_id;
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
        function setSubject($new_subject)
        {
            $this->subject = (string) $new_subject;
        }

        function getSubject()
        {
            return $this->subject;
        }

        //$description setter and getter
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getUserId()
        {
            return $this->user_id;
        }

        function getId()
        {
            return $this->id;
        }

        //Save a course to the database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (title, subject, description, user_id) VALUES
                ('{$this->getTitle()}',
                 '{$this->getSubject()}',
                 '{$this->getDescription()}',
                  {$this->getUserId()});
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
                $user_id        = $course['user_id'];
                $id             = $course['id'];

                $new_course = new Course($title, $subject, $description, $user_id, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        //Edit course info
        function updateCourse($new_title, $new_subject, $new_description)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET
                    title       = '{$new_title}',
                    subject     = '{$new_subject}',
                    description = '{$new_description}'
                WHERE id = {$this->getId()};");
                $this->setTitle($new_title);
                $this->setSubject($new_subject);
                $this->setDescription($new_description);
        }

        //Find course by id:
        static function find($search_id)
        {
            $found_course = NULL;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }
    }
?>
