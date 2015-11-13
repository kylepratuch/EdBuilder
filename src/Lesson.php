<?php

    class Lesson
    {
        private $title;
        private $objective;
        private $materials;
        private $body;
        private $id;

        function __construct($title, $objective, $materials, $body, $id = null)
        {
            $this->title = $title;
            $this->objective = $objective;
            $this->materials = $materials;
            $this->body = $body;
            $this->id = $id;
        }

        //setters and getters
        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setObjective($new_objective)
        {
            $this->objective = (string) $new_objective;
        }

        function getObjective()
        {
            return $this->objective;
        }

        function setMaterials($new_materials)
        {
            $this->materials = (string) $new_materials;
        }

        function getMaterials()
        {
            return $this->materials;
        }

        function setBody($new_body)
        {
            $this->body = (string) $new_body;
        }

        function getBody()
        {
            return $this->body;
        }

        function getId()
        {
            return $this->id;
        }

        //Save a lesson to the database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO lessons (title, objective, materials, body) VALUES
                ('{$this->getTitle()}',
                 '{$this->getObjective()}',
                 '{$this->getMaterials()}',
                 '{$this->getBody()}');
            ");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Delete a single lesson
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM lessons WHERE id = {$this->getId()};");
        }

        //Delete ALL lessons
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        //Get all lessons in table
        static function getAll()
        {
            $returned_lessons = $GLOBALS['DB']->query("SELECT * FROM lessons;");
            $lessons = array();
            foreach ($returned_lessons as $lesson) {
                $title      = $lesson['title'];
                $objective  = $lesson['objective'];
                $materials  = $lesson['materials'];
                $body       = $lesson['body'];
                $id         = $lesson['id'];

                $new_lesson = new Lesson($title, $objective, $materials, $body, $id);
                array_push($lessons, $new_lesson);
            }
            return $lessons;
        }










    }

?>
