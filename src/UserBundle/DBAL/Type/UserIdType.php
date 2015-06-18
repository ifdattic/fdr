<?php

namespace UserBundle\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\User\ValueObject\UserId;

class UserIdType extends Type
{
    const USERID = 'userid';

    /** {@inheritdoc} */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    /** {@inheritdoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::createFromString($value);
    }

    /** {@inheritdoc} */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getValue();
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return self::USERID;
    }
}
