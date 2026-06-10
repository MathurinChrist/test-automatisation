<?php
    namespace App\Tests\Controller;

    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

    class ItemControllerTest extends WebTestCase
    {
        public function testGetItems(): void
        {
            $client = static::createClient();

            $client->request('GET', '/items/');

            $this->assertResponseIsSuccessful();
            $data = json_decode(
                $client->getResponse()->getContent(),
                true
            );

            $this->assertIsArray($data);
        }

        public function testCreateItem(): void
        {
            $client = static::createClient();

            $client->request(
                'POST',
                '/item/create',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode([
                    'name' => 'Test item',
                    'content' => 'Mon contenu'
                ])
            );

            $this->assertResponseStatusCodeSame(201);

            $data = json_decode($client->getResponse()->getContent(), true);

            var_dump($data);

            $this->assertArrayHasKey('id', $data);
            $this->assertEquals('Test item', $data['name']);
            $this->assertEquals('Mon contenu', $data['content']);
        }
    }
