<?php

    namespace App\Tests;

    use App\Entity\User;
    use PHPUnit\Framework\TestCase;

    class UserTest extends TestCase
    {
        private function createValidUser(): User
        {
            return (new User())
                ->setName('Kimbembe')
                ->setFirstName('Mathurin')
                ->setEmail('mathurin@gmail.com')
                ->setPassword('Password123')
                ->setBirthDate(new \DateTime('2001-03-01'));
        }

        public function testValidUser(): void
        {
            $user = $this->createValidUser();

            $this->assertTrue($user->isValid());
        }

        public function testInvalidEmail(): void
        {
            $user = $this->createValidUser();
            $user->setEmail('invalid-email');

            $this->assertFalse($user->isValid());
        }

        public function testBlankName(): void
        {
            $user = $this->createValidUser();
            $user->setName('');

            $this->assertFalse($user->isValid());
        }

        public function testBlankFirstName(): void
        {
            $user = $this->createValidUser();
            $user->setFirstName('');

            $this->assertFalse($user->isValid());
        }

        public function testBlankPassword(): void
        {
            $user = $this->createValidUser();
            $user->setPassword('');

            $this->assertFalse($user->isValid());
        }

        public function testPasswordTooShort(): void
        {
            $user = $this->createValidUser();
            $user->setPassword('Pass1');

            $this->assertFalse($user->isValid());
        }

        public function testPasswordWithoutUppercase(): void
        {
            $user = $this->createValidUser();
            $user->setPassword('password123');

            $this->assertFalse($user->isValid());
        }

        public function testPasswordWithoutLowercase(): void
        {
            $user = $this->createValidUser();
            $user->setPassword('PASSWORD123');

            $this->assertFalse($user->isValid());
        }

        public function testPasswordWithoutNumber(): void
        {
            $user = $this->createValidUser();
            $user->setPassword('Password');

            $this->assertFalse($user->isValid());
        }

        public function testUserTooYoung(): void
        {
            $user = $this->createValidUser();

            $birthDate = (new \DateTime())->modify('-10 years');
            $user->setBirthDate($birthDate);

            $this->assertFalse($user->isValid());
        }

        public function testNullBirthDate(): void
        {
            $user = $this->createValidUser();

            $reflection = new \ReflectionClass($user);
            $property = $reflection->getProperty('birthDate');
            $property->setValue($user, null);

            $this->assertFalse($user->isValid());
        }
    }
