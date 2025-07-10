<?php

namespace App\Tests\Controller;

use App\Entity\Information;
use App\Repository\InformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class InformationControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $informationRepository;
    private string $path = '/information/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->informationRepository = $this->manager->getRepository(Information::class);

        foreach ($this->informationRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Information index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'information[nomInformation]' => 'Testing',
            'information[dateHeureInformation]' => 'Testing',
            'information[contenuInformation]' => 'Testing',
            'information[utilisateur]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->informationRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Information();
        $fixture->setNomInformation('My Title');
        $fixture->setDateHeureInformation('My Title');
        $fixture->setContenuInformation('My Title');
        $fixture->setUtilisateur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Information');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Information();
        $fixture->setNomInformation('Value');
        $fixture->setDateHeureInformation('Value');
        $fixture->setContenuInformation('Value');
        $fixture->setUtilisateur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'information[nomInformation]' => 'Something New',
            'information[dateHeureInformation]' => 'Something New',
            'information[contenuInformation]' => 'Something New',
            'information[utilisateur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/information/');

        $fixture = $this->informationRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomInformation());
        self::assertSame('Something New', $fixture[0]->getDateHeureInformation());
        self::assertSame('Something New', $fixture[0]->getContenuInformation());
        self::assertSame('Something New', $fixture[0]->getUtilisateur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Information();
        $fixture->setNomInformation('Value');
        $fixture->setDateHeureInformation('Value');
        $fixture->setContenuInformation('Value');
        $fixture->setUtilisateur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/information/');
        self::assertSame(0, $this->informationRepository->count([]));
    }
}
