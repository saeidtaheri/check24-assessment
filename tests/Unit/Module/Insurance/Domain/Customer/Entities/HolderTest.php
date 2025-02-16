<?php

namespace Tests\Unit\Module\Insurance\Domain\Customer\Entities;

use App\Module\Insurance\Application\Exceptions\ValidationException;
use App\Module\Insurance\Domain\Customer\Entities\Holder;
use PHPUnit\Framework\TestCase;

final class HolderTest extends TestCase
{
    public function test_it_should_create_holder_entity_with_valid_data(): void
    {
        $holder = new Holder(...[
            'type' => 'CONDUCTOR_PRINCIPAL',
            'birthDate' => '1985-06-15',
            'civilStatus' => 'CASADO',
            'id' => '98765432Y',
            'idType' => 'DNI',
            'licenseDate' => '2005-07-20',
            'profession' => 'Engineer',
            'sex' => 'HOMBRE',
        ]);

        $this->assertInstanceOf(Holder::class, $holder);
    }

    public function test_should_throws_exception_on_missing_type(): void
    {
        $this->expectException(ValidationException::class);
        new Holder(
            '',
            '1985-06-15',
            'CASADO',
            '98765432Y',
            'DNI',
            '2005-07-20',
            'Engineer',
            'HOMBRE'
        );
    }

    public function test_holder_with_nullable_fields_should_be_created(): void
    {
        $holder = new Holder(
            'CONDUCTOR_PRINCIPAL',
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertInstanceOf(Holder::class, $holder);
        $this->assertNull($holder->birthDate);
        $this->assertNull($holder->civilStatus);
        $this->assertNull($holder->id);
        $this->assertNull($holder->idType);
        $this->assertNull($holder->licenseDate);
        $this->assertNull($holder->profession);
        $this->assertNull($holder->sex);
    }
}
