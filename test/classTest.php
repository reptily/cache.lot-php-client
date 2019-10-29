<?php
namespace Cachelot\Test;

use PHPUnit\Framework\TestCase;
use Cachelot\Action as Cachelot;

class CachelotTest extends TestCase
{
    
    protected $Cachelot;
    
    public function setUp(): void{
        $this->Cachelot = new Cachelot();
    }
    
    public function tearDown(): void{
        //
	}
    
    /**
     * Begin Test!!!
     */
    
    public function testSet(){
        $result = $this->Cachelot->set("car","hyundai");
        $this->assertSame("OK",$result);
    }
    
    public function testGet(){
        $result = $this->Cachelot->get("car");
        $this->assertSame("hyundai",$result);
    }
    
    public function testShow(){
        $result = $this->Cachelot->show();
        $this->assertSame("car",$result);
    }       
    
    public function testSetArray(){
        $result = $this->Cachelot->set("bike",['ktm', 'yamaha', 'suzuki']);
        $this->assertSame("OK",$result);
    }
    
    public function testGetArray(){
        $result = $this->Cachelot->get("bike");
        $this->assertSame(['ktm', 'yamaha', 'suzuki'],$result);
    }
    
    public function testDel(){
        $result = $this->Cachelot->del("bike");
        $this->assertSame("OK",$result);
    }
    
    public function testDie(){
        $result = $this->Cachelot->die("bike",5);
        $this->assertSame("OK",$result);
        sleep(5);
        $result = $this->Cachelot->get("bike");
        $this->assertSame("undefined",$result);
    }
    
}