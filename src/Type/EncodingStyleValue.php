<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\Type;

use SimpleSAML\SOAP\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\Builtin\NMTokensValue;

use function explode;

/**
 * @package simplesaml/xml-soap
 */
class EncodingStyleValue extends NMTokensValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'encodingStyle';


    /**
     * Validate the value.
     *
     * @param string $value The value
     * @throws \SimpleSAML\XMLSchema\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        $sanitized = $this->sanitizeValue($value);
        Assert::stringNotEmpty($sanitized, SchemaViolationException::class);

        $list = explode(' ', $sanitized, C::UNBOUNDED_LIMIT);
        Assert::allValidAnyURI($list, SchemaViolationException::class);
    }
}
