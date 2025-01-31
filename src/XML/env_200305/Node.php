<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env_200305;

use SimpleSAML\XML\Type\AnyURIValue;
use SimpleSAML\XML\TypedTextContentTrait;

/**
 * Class representing a env:Node element.
 *
 * @package simplesaml/xml-soap
 */
final class Node extends AbstractSoapElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;
}
