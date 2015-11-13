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

    function testDelete()
    {
        $title = "Into the Wild";
        $description = "The life and death of Chris McCandless.";
        $test_unit = new Unit($title, $description);
        $test_unit->save();

        $title2 = "The Catcher in the Rye";
        $description2 = "Foul-mouthed kid is angsty.";
        $test_unit2 = new Unit($title2, $description2);
        $test_unit2->save();

        $test_unit->delete();
        $result = Unit::getAll();

        $this->assertEquals([$test_unit2], $result);
    }
}

?>
