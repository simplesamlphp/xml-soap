<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env_200305;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\Builtin\AnyURIValue;

/**
 * Class representing a env:Role element.
 *
 * @package simplesaml/xml-soap
 */
final class Role extends AbstractSoapElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;
}
