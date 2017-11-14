<?php
namespace AppBundle\DataFixtures\ORM;

use BlogBundle\Entity\Enquiry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 messages!
        for ($i = 0; $i < 20; $i++) {
            $enquiry = new Enquiry();
            $enquiry->setName('nom'.$i);
            $enquiry->setEmail('email'.$i);
            $enquiry->setSubject('subject'.$i);
            $enquiry->setBody('body'.$i);
            $manager->persist($enquiry);
        }

        $manager->flush();
    }
}