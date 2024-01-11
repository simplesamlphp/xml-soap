<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP12\XML\env;

use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-soap
 */
abstract class AbstractSoapElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SOAP_ENV_12;

    /** @var string */
    public const NS_PREFIX = 'env';
}
