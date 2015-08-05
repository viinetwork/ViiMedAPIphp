<?php namespace Viimed\PhpApi;


class SchemaAPITest extends \Codeception\TestCase\Test
{
    /**
     * @var \AcceptanceTester
     */
    protected $tester;


    // tests
    public function testCRUD()
    {
        $api = SchemaAPI::connect();

        $person = json_decode('{
            "firstName": "Aaron",
            "lastName": "Bullard",
            "age": 38
        }');

        // Create
        $record = $api->saveRecord("/schemas/person.json", $person);
        $this->assertTrue( property_exists($record, '_uuid') );

        // Find
        $getRecord = $api->findRecordByUUID( $record->_uuid );
        $this->assertEquals($record, $getRecord);

        // Update
        $record->firstName = "James";
        $updated = $api->updateRecord( $record );
        $this->assertEquals("James", $update->firstName);

        // Delete
        $api->deleteRecord($updated);
        $this->setExpectedException('Viimed\PhpApi\Exceptions\RequestException');
        $api->findRecordByUUID( $updated->_uuid );
    }
}
