<?php

namespace WishApp\Tests\Model\Wish\ValueObject;

use PHPUnit\Framework\TestCase;
use WishApp\Model\Wish\ValueObject\Description;

class DescriptionTest extends TestCase
{
    public function testCreation()
    {
        $description = new Description('Some description of something');

        $this->assertInstanceOf(Description::class, $description);
    }

    public function testCreationFromString()
    {
        $description = Description::fromString('Some another description...');

        $this->assertInstanceOf(Description::class, $description);
    }

    public function testCreationThrowsIfValueTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Description should be more than 1 symbol but less then 1000');

        Description::fromString('');
    }

    public function testCreationThrowsIfValueTooLong()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Description should be more than 1 symbol but less then 1000');

        Description::fromString(self::getLongDescription());
    }

    public function testValue()
    {
        $description = Description::fromString('Description of something...');

        $this->assertIsString($description->value());
        $this->assertEquals(
            'Description of something...',
            $description->value()
        );
    }

    public function testToString()
    {
        $description = Description::fromString('Description of something...');

        $this->assertEquals(
            'Description of something...',
            (string) $description
        );
    }

    private static function getLongDescription(): string
    {
        return
            'Lorem ipsumdolor sit amet, consectetur adipiscing elit. Morbi pharetra scelerisque convallis.
            Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla feugiat nisi et elementum luctus.
            Sed elementum in elit et interdum. Sed auctor erat mollis tortor gravida semper.
            Mauris dictum augue ut laoreet semper. Sed ut tempus enim. Integer quis feugiat turpis.
            Suspendisse varius ipsum a turpis posuere cursus.
            Integer molestie quam urna, bibendum consequat nisl varius ac.
            Mauris sed risus sed arcu dapibus vehicula.
            Pellentesque quam metus, finibus vel pellentesque non, dictum ac turpis.
            Nullam ut nulla non ante consectetur fermentum non sed nibh. Nunc facilisis dapibus urna ut pretium.
            Praesent ornare leo eget rutrum ultrices.
            In id pretium quam. Curabitur ac aliquam orci, sed mollis odio.
            Etiam pulvinar ornare lectus, ut mollis erat fermentum vel.
            Proin lacinia nibh vel ipsum gravida, sit amet dictum justo interdum.
            Mauris ullamcorper placerat pretium. Sed non lobortis dolor, nec id.';
    }
}
