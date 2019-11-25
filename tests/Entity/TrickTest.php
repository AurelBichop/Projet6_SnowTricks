<?php


namespace App\Tests\Entity;

use App\Entity\Trick;
use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{

    /**
     * permet de tester le slug avant sa persistence
     */
    public function testPrepersistTrick(){
        $trick = new Trick();
        $trick->setTitre(' Titre de trick en test');
        $trick->initSlug();

        $this->assertEquals('titre-de-trick-en-test', $trick->getSlug());
    }

}