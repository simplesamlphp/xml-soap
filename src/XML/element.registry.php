<?php

declare(strict_types=1);

return [
    'http://schemas.xmlsoap.org/soap/envelope/' => [
        'Body' => '\SimpleSAML\SOAP\XML\env_200106\Body',
        'Envelope' => '\SimpleSAML\SOAP\XML\env_200106\Envelope',
        'Fault' => '\SimpleSAML\SOAP\XML\env_200106\Fault',
        'Header' => '\SimpleSAML\SOAP\XML\env_200106\Header',
    ],
    'http://www.w3.org/2003/05/soap-envelope/' => [
        'Body' => '\SimpleSAML\SOAP\XML\env_200305\Body',
        'Code' => '\SimpleSAML\SOAP\XML\env_200305\Code',
        'Detail' => '\SimpleSAML\SOAP\XML\env_200305\Detail',
        'Envelope' => '\SimpleSAML\SOAP\XML\env_200305\Envelope',
        'Fault' => '\SimpleSAML\SOAP\XML\env_200305\Fault',
        'Header' => '\SimpleSAML\SOAP\XML\env_200305\Header',
        'Node' => '\SimpleSAML\SOAP\XML\env_200305\Node',
        'NotUnderstood' => '\SimpleSAML\SOAP\XML\env_200305\NotUnderstood',
        'Reason' => '\SimpleSAML\SOAP\XML\env_200305\Reason',
        'Role' => '\SimpleSAML\SOAP\XML\env_200305\Role',
        'Subcode' => '\SimpleSAML\SOAP\XML\env_200305\Subcode',
        'SupportedEnvelope' => '\SimpleSAML\SOAP\XML\env_200305\SupportedEnvelope',
        'Text' => '\SimpleSAML\SOAP\XML\env_200305\Text',
        'Upgrade' => '\SimpleSAML\SOAP\XML\env_200305\Upgrade',
        'Value' => '\SimpleSAML\SOAP\XML\env_200305\Value',
    ],
];
