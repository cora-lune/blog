<?php
namespace BlogBundle\DataFixtures\ORM;

use BlogBundle\Entity\Enquiry;
use BlogBundle\Entity\Post;
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

            $post = new Post();
            $post->setTitle('A day with Symfony2'.$i);
            $post->setArticle('Donec imperdiet ante sed diam consequat et dictum erat faucibus. Aliquam sit
            amet vehicula leo. Morbi urna dui, tempor ac posuere et, rutrum at dui.
            Curabitur neque quam, ultricies ut imperdiet id, ornare varius arcu. Ut congue
            urna sit amet tellus malesuada nec elementum risus molestie. Donec gravida
            tellus sed tortor adipiscing fringilla. Donec nulla mauris, mollis egestas
            condimentum laoreet, lacinia vel lorem. Morbi vitae justo sit amet felis
            vehicula commodo a placerat lacus. Mauris at est elit, nec vehicula urna. Duis a
            lacus nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
            posuere cubilia Curae.'.$i);
            $post->setAuthor('dsyph3r'.$i);
            $manager->persist($post);

        }

        $manager->flush();
    }

}