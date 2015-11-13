<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/User.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class UserTest extends PHPUnit_Framework_TestCase
{
    // Clear test database on each test run
    protected function tearDown()
    {
        User::deleteAll();
    }

    // This tests our save and getAll functions:
    function testSave()
    {
        //Arrange
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);

        //Act
        $test_user->save();
        $result = User::getAll();

        //Assert
        $this->assertEquals($test_user, $result[0]);
    }

    function testDelete()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";
        $signed_in2 = 0;
        $test_user2 = new User($name2, $password2, $email2, $signed_in2);
        $test_user2->save();

        $test_user->delete();
        $result = User::getAll();

        $this->assertEquals([$test_user2], $result);

    }

    function testFind()
    {
        $name = "John Doe";
        $password = "password";
        $email = "johndoe@osa.biz";
        $signed_in = 0;
        $test_user = new User($name, $password, $email, $signed_in);
        $test_user->save();

        $name2 = "Jane Boe";
        $password2 = "wordpass";
        $email2 = "janeboe@osa.biz";
        $signed_in2 = 0;
        $test_user2 = new User($name2, $password2, $email2, $signed_in2);
        $test_user2->save();

        $result = User::find($test_user->getId());

        $this->assertEquals($test_user, $result);
    }
}

?>
