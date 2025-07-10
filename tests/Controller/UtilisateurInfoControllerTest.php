<?php

namespace App\Tests\Controller;

use App\Entity\UtilisateurInfo;
use App\Repository\UtilisateurInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UtilisateurInfoControllerTest extends WebTestCase{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $utilisateurInfoRepository;
    private string $path = '/utilisateur/info/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->utilisateurInfoRepository = $this->manager->getRepository(UtilisateurInfo::class);

        foreach ($this->utilisateurInfoRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('UtilisateurInfo index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'utilisateur_info[nomUtilisateur]' => 'Testing',
            'utilisateur_info[prenomUtilisateur]' => 'Testing',
            'utilisateur_info[dateNaissanceUtilisateur]' => 'Testing',
            'utilisateur_info[utilisateur]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->utilisateurInfoRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new UtilisateurInfo();
        $fixture->setNomUtilisateur('My Title');
        $fixture->setPrenomUtilisateur('My Title');
        $fixture->setDateNaissanceUtilisateur('My Title');
        $fixture->setUtilisateur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('UtilisateurInfo');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new UtilisateurInfo();
        $fixture->setNomUtilisateur('Value');
        $fixture->setPrenomUtilisateur('Value');
        $fixture->setDateNaissanceUtilisateur('Value');
        $fixture->setUtilisateur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur_info[nomUtilisateur]' => 'Something New',
            'utilisateur_info[prenomUtilisateur]' => 'Something New',
            'utilisateur_info[dateNaissanceUtilisateur]' => 'Something New',
            'utilisateur_info[utilisateur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utilisateur/info/');

        $fixture = $this->utilisateurInfoRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomUtilisateur());
        self::assertSame('Something New', $fixture[0]->getPrenomUtilisateur());
        self::assertSame('Something New', $fixture[0]->getDateNaissanceUtilisateur());
        self::assertSame('Something New', $fixture[0]->getUtilisateur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new UtilisateurInfo();
        $fixture->setNomUtilisateur('Value');
        $fixture->setPrenomUtilisateur('Value');
        $fixture->setDateNaissanceUtilisateur('Value');
        $fixture->setUtilisateur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/utilisateur/info/');
        self::assertSame(0, $this->utilisateurInfoRepository->count([]));
    }
}
