<?php

declare(strict_types=1);

namespace Edubovic\GofPhp\Structural\Facade\Operation;

use SimpleXMLElement;

final class SubtractOperation extends AbstractOperation
{
    public function execute(int $a, int $b): int
    {
        $response = $this->getHttpClient()->post($this->getHost(), $this->getXml($a, $b));

        $xml = new SimpleXMLElement($response);
        $result = $xml->xpath('/soap:Envelope/soap:Body')[0];

        return (int)$result->SubtractResponse->SubtractResult->__toString();
    }

    private function getXml(int $a, int $b): string
    {
        return <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <Subtract xmlns="http://tempuri.org/">
      <intA>$a</intA>
      <intB>$b</intB>
    </Subtract>
  </soap12:Body>
</soap12:Envelope>
XML;
    }
}
