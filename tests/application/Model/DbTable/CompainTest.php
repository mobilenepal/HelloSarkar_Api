<?php
//require_once 'application/models/DbTable/Complain.php';
//require_once 'PHPUnit/Framework/TestCase.php';
/**
 * Model_DbTable_Complain test case.
 */
class Model_DbTable_CompainTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Model_DbTable_Complain
     */
    private $Model_DbTable_Complain;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        // TODO Auto-generated Model_DbTable_Compain_Test::setUp()
        $this->Model_DbTable_Complain = new Model_DbTable_Complain(/* parameters */);
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        // TODO Auto-generated Model_DbTable_Compain_Test::tearDown()
        $this->Model_DbTable_Complain = null;
        parent::tearDown();
    }
    /**
     * Constructs the test case.
     */
    public function __construct ()
    {
        // TODO Auto-generated constructor
    }
    /**
     * Tests Model_DbTable_Complain->insert()
     */
    public function testInsert ()
    {
        // TODO Auto-generated Model_DbTable_Compain_Test->testInsert()
        $this->markTestIncomplete("insert test not implemented");
        $this->Model_DbTable_Complain->insert(/* parameters */);
    }
    /**
     * Tests Model_DbTable_Complain->getAllComplains()
     */
    public function testGetAllComplains ()
    {
        // TODO Auto-generated Model_DbTable_Compain_Test->testGetAllComplains()
        $this->markTestIncomplete(
        "getAllComplains test not implemented");
        $this->Model_DbTable_Complain->getAllComplains(/* parameters */);
    }
    /**
     * Tests Model_DbTable_Complain->getComplain()
     */
    public function testGetComplain ()
    {
        // TODO Auto-generated Model_DbTable_Compain_Test->testGetComplain()
        $this->markTestIncomplete("getComplain test not implemented");
        $this->Model_DbTable_Complain->getComplain(/* parameters */);
    }
    /**
     * Tests Model_DbTable_Complain->getResponseId()
     */
    public function testGetResponseId ()
    {              
        $this->Model_DbTable_Complain->getResponseId();
    }
}

