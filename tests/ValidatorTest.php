<?php

use PHPUnit\Framework\TestCase;
use Lento\Validator;
use Lento\Attributes\NotBlank;
use Lento\Attributes\Email;
use Lento\Attributes\Length;
use Lento\Attributes\Regex;

class DummyDTO1 {
    #[NotBlank]
    public $field1;

    #[Email]
    public $email;
}

class DummyDTO2 {
    #[Length(min: 3, max: 5)]
    public $name;

    #[Regex(pattern: '/^\d{4}$/')]
    public $pin;
}

class ValidatorTest extends TestCase
{
    public function testNotBlankValidation()
    {
        $validator = new Validator();

        $dto = new DummyDTO1();
        $dto->field1 = '';
        $errors = $validator->validate($dto);

        $this->assertArrayHasKey('field1', $errors);
        $this->assertEquals('This value should not be blank.', $errors['field1']);

        $dto->field1 = 'value';
        $errors = $validator->validate($dto);
        $this->assertArrayNotHasKey('field1', $errors);
    }

    public function testEmailValidation()
    {
        $validator = new Validator();
        $dto = new DummyDTO1();
        $dto->email = 'not-an-email';
        $errors = $validator->validate($dto);
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals('This value is not a valid email address.', $errors['email']);

        $dto->email = 'user@example.com';
        $errors = $validator->validate($dto);
        $this->assertArrayNotHasKey('email', $errors);
    }

    public function testLengthValidation()
    {
        $validator = new Validator();
        $dto = new DummyDTO2();
        $dto->name = 'ab';
        $errors = $validator->validate($dto);
        $this->assertArrayHasKey('name', $errors);
        $this->assertStringContainsString('too short', $errors['name']);

        $dto->name = 'abcdef';
        $errors = $validator->validate($dto);
        $this->assertArrayHasKey('name', $errors);
        $this->assertStringContainsString('too long', $errors['name']);

        $dto->name = 'abcd';
        $errors = $validator->validate($dto);
        $this->assertArrayNotHasKey('name', $errors);
    }

    public function testRegexValidation()
    {
        $validator = new Validator();
        $dto = new DummyDTO2();
        $dto->pin = '123';
        $errors = $validator->validate($dto);
        $this->assertArrayHasKey('pin', $errors);
        $this->assertStringContainsString('does not match', $errors['pin']);

        $dto->pin = '1234';
        $errors = $validator->validate($dto);
        $this->assertArrayNotHasKey('pin', $errors);
    }

    public function testMultipleErrors()
    {
        $validator = new Validator();
        $dto = new DummyDTO1();
        $dto->field1 = '';
        $dto->email = 'invalid';
        $errors = $validator->validate($dto);

        $this->assertArrayHasKey('field1', $errors);
        $this->assertArrayHasKey('email', $errors);
    }

    public function testNoErrors()
    {
        $validator = new Validator();
        $dto1 = new DummyDTO1();
        $dto1->field1 = 'not blank';
        $dto1->email = 'me@a.com';
        $errors = $validator->validate($dto1);
        $this->assertEmpty($errors);

        $dto2 = new DummyDTO2();
        $dto2->name = 'abcd';
        $dto2->pin = '1234';
        $errors = $validator->validate($dto2);
        $this->assertEmpty($errors);
    }
}
