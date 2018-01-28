<?php
require "tests/config.php";

class ClientModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     * Para ver los debug logs se debe correr
     * el test con el flag --debug
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreate(){
        $client = new Client(null, "Jhon", "Doe", "jhon@doe.com", "", 25, 1);
        $r = $client->create();

        $this->assertEquals($r["error"],0);
        
        $lclient = Client::getById($r["getID"]);
        
        \Codeception\Util\Debug::debug("Loaded Client: ");
        \Codeception\Util\Debug::debug($lclient);
        
        $this->assertEquals(get_class($lclient),"Client");
    }
    
    public function testUpdate(){

        $lclient = Client::getById(7);
        $lclient->setName("Cliente7");
        $r = $lclient->update();
        \Codeception\Util\Debug::debug($r);
        
        $this->assertEquals($r["error"],0);
    }
    
    public function testBornAndDie()
    {   
        $client = new Client(null, "Jhon", "Doe", "jhon@doe.com", 
              "foo.png", 25, 1);
        $r = $client->create();
        $dbClient = Client::getById($r["getID"]);
        $this->assertEquals($client,$dbClient);
        \Codeception\Util\Debug::debug($client->getName()." ".
                $client->getLastname()." Client born");
        
        $r = $client->delete();
        $this->assertEquals(0,$r["error"]);
        \Codeception\Util\Debug::debug($client->getName()." ".
                $client->getLastname()." Client die");
    }
    
    public function testRelationships()
    {
        
    }
    
}