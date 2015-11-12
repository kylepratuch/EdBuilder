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
    // protected function tearDown()
    // {
    //     User::deleteAll();
    // }

    function testSave()
    //Arrange

}

?>
