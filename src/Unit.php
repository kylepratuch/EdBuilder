<?php

    class Unit
    {
        private $title;
        private $description;
        private $course_id;
        private $id;

        function __construct($title, $description, $course_id, $id = null)
        {
            $this->title = $title;
            $this->description = $description;
            $this->course_id = $course_id;
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

        //$description setter and getter
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getCourseId()
        {
            return $this->course_id;
        }

        function getId()
        {
            return $this->id;
        }

        //Save a unit of study to the database
        function save()
        {
            //Handle apostrophes before executing MySQL statements
            $temp_title = str_replace(["'"], "''", $this->getTitle());
            $temp_description = str_replace(["'"], "''", $this->getDescription());

            $GLOBALS['DB']->exec("INSERT INTO units (title, description, course_id) VALUES
                ('{$temp_title}',
                 '{$temp_description}',
                  {$this->getCourseId()});
            ");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Delete a single unit
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM units WHERE id = {$this->getId()};");
        }

        //Delete ALL units
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM units;");
        }

        //Get all units in table
        static function getAll()
        {
            $returned_units = $GLOBALS['DB']->query("SELECT * FROM units;");
            $units = array();
            foreach ($returned_units as $unit) {
                $title          = $unit['title'];
                $description    = $unit['description'];
                $course_id      = $unit['course_id'];
                $id             = $unit['id'];

                $new_unit = new Unit($title, $description, $course_id, $id);
                array_push($units, $new_unit);
            }
            return $units;
        }

        //Edit unit info
        function updateUnit($new_title, $new_description)
        {
            $temp_new_title = str_replace(["'"], "''", $new_title);
            $temp_new_description = str_replace(["'"], "''", $new_description);

            $GLOBALS['DB']->exec("UPDATE units SET
                    title       = '{$temp_new_title}',
                    description = '{$temp_new_description}'
                WHERE id = {$this->getId()};");

                $this->setTitle($new_title);
                $this->setDescription($new_description);
        }

        //Find unit by id:
        static function find($search_id)
        {
            $found_unit = NULL;
            $units = Unit::getAll();
            foreach($units as $unit) {
                $unit_id = $unit->getId();
                if($unit_id == $search_id) {
                    $found_unit = $unit;
                }
            }
            return $found_unit;
        }

        //Get lessons in unit:
        function getLessons()
        {
            $returned_lessons = $GLOBALS['DB']->query("SELECT * FROM lessons WHERE unit_id = {$this->getId()};");
            $unit_lessons = array();
            foreach ($returned_lessons as $lesson) {
                $lesson_id = $lesson['id'];
                $found_lesson = Lesson::find($lesson_id);

                array_push($unit_lessons, $found_lesson);
            }
            return $unit_lessons;
        }
    }
?>
