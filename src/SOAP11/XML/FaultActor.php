<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Class representing a faultactor element.
 *
 * @package simplesaml/xml-soap
 */
final class FaultActor extends AbstractElement
{
    use TypedTextContentTrait;


    /** @var string */
    public const LOCALNAME = 'faultactor';

    /** @var null */
    public const NS = null;

    /** @var null */
    public const NS_PREFIX = null;

    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;
}
