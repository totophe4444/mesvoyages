<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteValidationsTest
 *
 * @author tophe
 */
class VisiteValidationsTest extends KernelTestCase{
    public function getVisiste(){
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    
    public function testValideNoteVisite(){
        $visite = $this->getVisiste()->setNote(10);
        $this->assertErrors($visite, 0);
    }
    
    public function testNonValideNoteVisite(){
        $visite = $this->getVisiste()->setNote(21);
        $this->assertErrors($visite, 1);
    }
    
    public function testNonValidTempmaxVisite(){
        $visite = $this->getVisiste()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18, le test devrait échoué");
    }
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $error = self::$container->get('validator')->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message); 
    }
}
