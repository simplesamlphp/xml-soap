<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\Type;

use SimpleSAML\SOAP\Assert\Assert;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\Builtin\BooleanValue;
use SimpleSAML\XMLSchema\Type\Helper\AttributeTypeInterface;

use function boolval;

/**
 * @package simplesaml/xml-common
 */
class MustUnderstandValue extends BooleanValue implements AttributeTypeInterface
{
    /** @var string */
    public const SCHEMA_TYPE = 'boolean';


    /**
     * Validate the value.
     *
     * @param string $value
     * @throws \SimpleSAML\XMLSchema\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        // Note: value must already be sanitized before validating
        Assert::validMustUnderstand($this->sanitizeValue($value), SchemaViolationException::class);
    }


    /**
     * @param boolean $value
     * @return static
     */
    public static function fromBoolean(bool $value): static
    {
        return new static(
            $value === true ? '1' : '0',
        );
    }


    /**
     * @return boolean $value
     */
    public function toBoolean(): bool
    {
        return boolval($this->getValue());
    }


    /**
     * Convert this value to an attribute
     *
     * @return \SimpleSAML\XML\Attribute
     */
    public function toAttribute(): Attribute
    {
        return new Attribute(C::NS_SOAP_ENV_11, 'SOAP-ENV', 'mustUnderstand', $this);
    }
}
