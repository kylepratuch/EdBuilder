<?php

    class Lesson
    {
        private $title;
        private $objective;
        private $materials;
        private $body;
        private $unit_id;
        private $id;

        function __construct($title, $objective, $materials, $body, $unit_id, $id = null)
        {
            $this->title = $title;
            $this->objective = $objective;
            $this->materials = $materials;
            $this->body = $body;
            $this->unit_id = $unit_id;
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

        function getUnitId()
        {
            return $this->unit_id;
        }

        function getId()
        {
            return $this->id;
        }

        //Save a lesson to the database
        function save()
        {
            //Handle apostrophes before executing MySQL statements
            $temp_title = str_replace(["'"], "''", $this->getTitle());
            $temp_objective = str_replace(["'"], "''", $this->getObjective());
            $temp_materials = str_replace(["'"], "''", $this->getMaterials());
            $temp_body = str_replace(["'"], "''", $this->getBody());

            $GLOBALS['DB']->exec("INSERT INTO lessons (title, objective, materials, body, unit_id) VALUES
                ('{$temp_title}',
                 '{$temp_objective}',
                 '{$temp_materials}',
                 '{$temp_body}',
                  {$this->getUnitId()});
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
            $GLOBALS['DB']->exec("DELETE FROM lessons;");
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
                $unit_id    = $lesson['unit_id'];
                $id         = $lesson['id'];

                $new_lesson = new Lesson($title, $objective, $materials, $body, $unit_id, $id);
                array_push($lessons, $new_lesson);
            }
            return $lessons;
        }

        //Update lesson
        function updateLesson($new_title, $new_objective, $new_materials, $new_body)
        {
            //Handle apostorphes before executing MySQL statement
            $temp_new_title = str_replace(["'"], "''", $new_title);
            $temp_new_objective = str_replace(["'"], "''", $new_objective);
            $temp_new_materials = str_replace(["'"], "''", $new_materials);
            $temp_new_body = str_replace(["'"], "''", $new_body);

            $GLOBALS['DB']->exec("UPDATE lessons SET
                    title       = '{$temp_new_title}',
                    objective   = '{$temp_new_objective}',
                    materials   = '{$temp_new_materials}',
                    body        = '{$temp_new_body}'
                WHERE id = {$this->getId()};");
                $this->setTitle($new_title);
                $this->setObjective($new_objective);
                $this->setMaterials($new_materials);
                $this->setBody($new_body);
        }

        //Find lesson by id:
        static function find($search_id)
        {
            $found_lesson = NULL;
            $lessons = Lesson::getAll();
            foreach($lessons as $lesson) {
                $lesson_id = $lesson->getId();
                if($lesson_id == $search_id) {
                    $found_lesson = $lesson;
                }
            }
            return $found_lesson;
        }
    }

?>
