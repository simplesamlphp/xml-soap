<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env_200106;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\XML\Type\StringValue;
use SimpleSAML\XML\TypedTextContentTrait;

/**
 * Class representing a faultstring element.
 *
 * @package simplesaml/xml-soap
 */
final class FaultString extends AbstractElement
{
    use TypedTextContentTrait;

    /** @var string */
    public const LOCALNAME = 'faultstring';

    /** @var null */
    public const NS = null;

    /** @var null */
    public const NS_PREFIX = null;

    /** @var string */
    public const TEXTCONTENT_TYPE = StringValue::class;
}
