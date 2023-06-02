<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP;

/**
 * Class holding constants relevant for XML SOAP
 *
 * @package simplesamlphp/xml-soap
 */

class Constants extends \SimpleSAML\XML\Constants
{
    /**
     * The namespace for the SOAP envelope 1.1.
     */
    public const NS_SOAP_ENV_11 = 'http://schemas.xmlsoap.org/soap/envelope/';

    /**
     * The namespace for the SOAP envelope 1.2.
     */
    public const NS_SOAP_ENV_12 = 'http://www.w3.org/2003/05/soap-envelope/';

    /**
     * The namespace for SOAP encoding.
     */
    public const NS_SOAP_ENC = 'http://www.w3.org/2003/05/soap-encoding';

    /**
     * The fault codes defined by the specification
     */
    public const FAULT_VERSION_MISMATCH = 'VersionMismatch';
    public const FAULT_MUST_UNDERSTAND = 'MustUnderstand';
    public const FAULT_SENDER = 'Sender';
    public const FAULT_RESPONDER = 'Responder';
    public const FAULT_DATA_ENCODING_UNKNOWN = 'DataEncodingUnknown';

    public const FAULT_CODES = [
        self::FAULT_VERSION_MISMATCH,
        self::FAULT_MUST_UNDERSTAND,
        self::FAULT_SENDER,
        self::FAULT_RESPONDER,
        self::FAULT_DATA_ENCODING_UNKNOWN,
    ];

    public const SOAP_ACTOR_NEXT = 'http://schemas.xmlsoap.org/soap/actor/next';
}
