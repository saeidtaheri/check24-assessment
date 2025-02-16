<?php

namespace App\Module\Insurance\Infrastructure\Generators;

use App\Module\Insurance\Application\Interfaces\Generator\GeneratorInterface;

final class XmlGenerator implements GeneratorInterface
{
    public function generate($data): string
    {
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $request = $xml->createElement('TarificacionThirdPartyRequest');

        foreach ($data->toArray() as $child => $item) {
            if (is_object($item) && method_exists($item, 'toArray')) {
                $datos = $xml->createElement('Datos');
                $request->appendChild($datos);
                $childElement = $xml->createElement(ucfirst($child));
                $datos->appendChild($childElement);
                foreach ($item->toArray() as $key => $value) {
                    $element = $xml->createElement(ucfirst($key), $value);
                    $childElement->appendChild($element);
                }
            } else {
                $element = $xml->createElement(ucfirst($child), $item);
                $request->appendChild($element);
            }
        }
        $xml->appendChild($request);

        return $xml->saveXML();
    }
}