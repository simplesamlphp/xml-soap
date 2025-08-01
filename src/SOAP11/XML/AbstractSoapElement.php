<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML;

use SimpleSAML\SOAP11\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-soap
 */
abstract class AbstractSoapElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SOAP_ENV;

    /** @var string */
    public const NS_PREFIX = 'SOAP-ENV';

    /** @var string */
    public const SCHEMA = 'resources/schemas/soap-envelope-1.1.xsd';
}
