<?php

namespace App\Component\Insurance\Quotation\Generator;

final class XmlGenerator implements GeneratorInterface
{
    public function generate($data): string
    {
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $request = $xml->createElement('InsuranceRequest');
        foreach ($data->toArray() as $key => $value) {
            $element = $xml->createElement($key, $value);
            $request->appendChild($element);
        }
        $xml->appendChild($request);

        return $xml->saveXML();
    }
}