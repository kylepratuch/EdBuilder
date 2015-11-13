<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Unit.php";

$server = 'mysql:host=localhost;dbname=builder_test_database';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class UnitTest extends PHPUnit_Framework_TestCase
{
    //Clear test database on each test run
    protected function tearDown()
    {
        Unit::deleteAll();
    }

    //Test our CRUD:
    function testSave()
    {
        //Arrange
        $title = "Into the Wild";
        $description = "The life and death of Chris McCandless.";
        $test_unit = new Unit($title, $description);

        //Act
        $test_unit->save();
        $result = Unit::getAll();

        //Assert
        $this->assertEquals($test_unit, $result[0]);
    }
}

?>
