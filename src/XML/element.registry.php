<?php

declare(strict_types=1);

return [
    'http://schemas.xmlsoap.org/soap/envelope/' => [
        'Body' => '\SimpleSAML\SOAP\XML\env_200106\Body',
        'Detail' => '\SimpleSAML\SOAP\XML\env_200106\Detail',
        'Envelope' => '\SimpleSAML\SOAP\XML\env_200106\Envelope',
        'Fault' => '\SimpleSAML\SOAP\XML\env_200106\Fault',
        'FaultActor' => '\SimpleSAML\SOAP\XML\env_200106\FaultActor',
        'FaultCode' => '\SimpleSAML\SOAP\XML\env_200106\FaultCode',
        'FaultString' => '\SimpleSAML\SOAP\XML\env_200106\FaultString',
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
        'SubCode' => '\SimpleSAML\SOAP\XML\env_200305\SubCode',
        'SupportedEnvelope' => '\SimpleSAML\SOAP\XML\env_200305\SupportedEnvelope',
        'Text' => '\SimpleSAML\SOAP\XML\env_200305\Text',
        'Upgrade' => '\SimpleSAML\SOAP\XML\env_200305\Upgrade',
        'Value' => '\SimpleSAML\SOAP\XML\env_200305\Value',
    ],
];
