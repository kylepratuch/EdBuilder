<?php

    class User
    {
        private $name;
        private $password;
        private $email;
        private $signed_in;
        private $id;


        function __construct($name, $password, $email, $signed_in, $id = null)
        {
            $this->name = $name;
            //Will worry about password hashing later.
            // $passwordHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
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

        // //Create a new User - use this for password hashing?
        // function createUser()
        // {
        //
        // }

        //Save a user to the database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO users (name, password, email, signed_in) VALUES
                ('{$this->getName()}',
                 '{$this->getPassword()}',
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
    }
?>
