<?php

namespace App\Tests\Controller;

use App\Entity\Entree;
use App\Repository\EntreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EntreeControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $entreeRepository;
    private string $path = '/entree/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->entreeRepository = $this->manager->getRepository(Entree::class);

        foreach ($this->entreeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Entree index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'entree[dateHeureEntree]' => 'Testing',
            'entree[commentaire]' => 'Testing',
            'entree[journal]' => 'Testing',
            'entree[emotion]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->entreeRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Entree();
        $fixture->setDateHeureEntree('My Title');
        $fixture->setCommentaire('My Title');
        $fixture->setJournal('My Title');
        $fixture->setEmotion('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Entree');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Entree();
        $fixture->setDateHeureEntree('Value');
        $fixture->setCommentaire('Value');
        $fixture->setJournal('Value');
        $fixture->setEmotion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'entree[dateHeureEntree]' => 'Something New',
            'entree[commentaire]' => 'Something New',
            'entree[journal]' => 'Something New',
            'entree[emotion]' => 'Something New',
        ]);

        self::assertResponseRedirects('/entree/');

        $fixture = $this->entreeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateHeureEntree());
        self::assertSame('Something New', $fixture[0]->getCommentaire());
        self::assertSame('Something New', $fixture[0]->getJournal());
        self::assertSame('Something New', $fixture[0]->getEmotion());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Entree();
        $fixture->setDateHeureEntree('Value');
        $fixture->setCommentaire('Value');
        $fixture->setJournal('Value');
        $fixture->setEmotion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/entree/');
        self::assertSame(0, $this->entreeRepository->count([]));
    }
}
