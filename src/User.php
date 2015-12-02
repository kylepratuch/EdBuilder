<?php

    class User
    {
        private $name;
        private $password;
        private $email;
        private $signed_in;
        private $id;

        function __construct($name, $password, $email, $signed_in = 0, $id = null)
        {
            $this->name = $name;
            $this->password = $password;
            $this->email = $email;
            $this->signed_in = $signed_in;
            $this->id = $id;
        }

        //$name setter and getter
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        //$password setter and getter
        function setPassword($new_password)
        {
            $this->password = $new_password;
        }

        function getPassword()
        {
            return $this->password;
        }

        function getHash()
        {
            $temp_name = str_replace(["'"], "''", $this->getName());

            $query = $GLOBALS['DB']->query("SELECT password FROM users WHERE name = '{$temp_name}';");
            $pass = $query->fetch(PDO::FETCH_ASSOC);
            $hash = $pass['password'];
            return $hash;
        }

        //$email setter and getter
        function setEmail($new_email)
        {
            $this->email = (string) $new_email;
        }

        function getEmail()
        {
            return $this->email;
        }

        //$signed_in setter and getter
        function setSignedIn($new_signed_in)
        {
            $this->signed_in = $new_signed_in;
        }

        function getSignedIn()
        {
            return $this->signed_in;
        }

        //$id getter
        function getId()
        {
            return $this->id;
        }

        //Save a user to the database
        function save()
        {
            $temp_name = str_replace(["'"], "''", $this->getName());
            $temp_pass = str_replace(["'"], "''", $this->getPassword());

            $GLOBALS['DB']->exec("INSERT INTO users (name, password, email, signed_in) VALUES
                ('{$temp_name}',
                 '{$temp_pass}',
                 '{$this->getEmail()}',
                  {$this->getSignedIn()});
            ");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Delete a single user
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id = {$this->getId()};");
        }

        //Delete ALL users
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users;");
        }

        //Get all users in table
        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            $users = array();
            foreach ($returned_users as $user) {
                $name       = $user['name'];
                $password   = $user['password'];
                $email      = $user['email'];
                $signed_in  = $user['signed_in'];
                $id         = $user['id'];

                $new_user = new User($name, $password, $email, $signed_in, $id);
                array_push($users, $new_user);
            }
            return $users;
        }

        //Edit user's info
        function updateUser($new_name, $new_password, $new_email)
        {
            $temp_new_name = str_replace(["'"], "''", $new_name);
            $temp_new_pass = str_replace(["'"], "''", $new_password);

            $GLOBALS['DB']->exec("UPDATE users SET
                    name        = '{$temp_new_name}',
                    password    = '{$temp_new_pass}',
                    email       = '{$new_email}'
                WHERE id = {$this->getId()};");
                $this->setName($new_name);
                $this->setPassword($new_password);
                $this->setEmail($new_email);
        }

        //Find user by id:
        static function find($search_id)
        {
            $found_user = NULL;
            $users = User::getAll();
            foreach($users as $user) {
                $user_id = $user->getId();
                if($user_id == $search_id) {
                    $found_user = $user;
                }
            }
            return $found_user;
        }

        //Find user by username:
        static function search($search_name)
        {
            $found_user = NULL;
            $users = User::getAll();
            foreach($users as $user) {
                $user_name = $user->getName();
                if($user_name == $search_name) {
                    $found_user = $user;
                }
            }
            return $found_user;
        }

        //Get courses on User's account
        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses WHERE user_id = {$this->getId()};");
            $user_courses = array();
            foreach ($returned_courses as $course) {
                $course_id = $course['id'];
                $found_course = Course::find($course_id);

                array_push($user_courses, $found_course);
            }
            return $user_courses;
        }
    }
?>
