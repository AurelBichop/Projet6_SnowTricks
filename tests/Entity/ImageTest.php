<?php


namespace App\Tests\Entity;

use App\Entity\Image;
use App\Entity\Trick;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    /**
     * Permet de verifier les setters et getter de l'objet image
     */
    public function testImage(){

        $trick = new Trick();
        $trick->setTitre('trick test')
            ->setCreatedAt(new \DateTime('-7days'))
            ->setDescription('description du super trick');


        $image = new Image();
        $image->setTitle('Image test')
            ->setUrl('monimage')
            ->setTrick($trick);

        $this->assertEquals('Image test', $image->getTitle());
        $this->assertEquals('monimage', $image->getUrl());
        $this->assertInstanceOf(Trick::class, $image->getTrick());
    }
}