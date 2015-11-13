<?php

    class Unit
    {
        private $title;
        private $description;
        private $id;

        function __construct($title, $description, $id = null)
        {
            $this->title = $title;
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

        //$description setter and getter
        function setDescription($new_description)
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

        //Save a unit of study to the database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO units (title, description) VALUES
                ('{$this->getTitle()}',
                 '{$this->getDescription()}');
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
                $id             = $unit['id'];

                $new_unit = new Unit($title, $description, $id);
                array_push($units, $new_unit);
            }
            return $units;
        }

        //Edit unit info
        function updateUnit($new_title, $new_description)
        {
            $GLOBALS['DB']->exec("UPDATE units SET
                    title = '{$new_title}',
                    description = '{$new_description}'
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
    }
?>
