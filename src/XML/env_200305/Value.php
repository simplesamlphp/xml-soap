<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env_200305;

use SimpleSAML\XML\Type\QNameValue;
use SimpleSAML\XML\TypedTextContentTrait;

/**
 * Class representing a env:Value element.
 *
 * @package simplesaml/xml-soap
 */
final class Value extends AbstractSoapElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = QNameValue::class;
}
