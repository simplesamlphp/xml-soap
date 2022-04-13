<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env;

use SimpleSAML\XML\AbstractXMLElement;
use SimpleSAML\SOAP\Constants as C;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-soap
 */
abstract class AbstractSoapElement extends AbstractXMLElement
{
    /** @var string */
    public const NS = C::NS_SOAP_ENV;

    /** @var string */
    public const NS_PREFIX = 'env';
}
