<?php

namespace App\Tests\Unit\Component\Insurance\Quotation\Generator;

use App\Component\Insurance\Quotation\Exception\ValidationException;
use App\Component\Insurance\Quotation\Generator\XmlGenerator;
use App\Component\Insurance\Quotation\InsuranceRequest;
use PHPUnit\Framework\TestCase;

class XmlGeneratorTest extends TestCase
{
    public function test_it_should_shows_validation_error()
    {
        $this->expectException(ValidationException::class);

        $data = json_decode(
            '{
                  "CondPpalEsTomador": "test",
                  "ConductorUnico": "NO",
                  "AnosSegAnte": 5,
                  "NroCondOca": 2,
                  "SeguroEnVigor": "YES"
                }',
            true
        );

        InsuranceRequest::fromArray($data);
    }

    public function test_it_should_create_xml_string()
    {
        $data = json_decode(
            '{
                  "CondPpalEsTomador": "YES",
                  "ConductorUnico": "NO",
                  "AnosSegAnte": 5,
                  "NroCondOca": 2,
                  "SeguroEnVigor": "YES"
                }',
            true
        );

        $dto = InsuranceRequest::fromArray($data);

        $xmlGenerator = new XmlGenerator();

        $sampleOutput = '<?xml version="1.0" encoding="UTF-8"?>
            <InsuranceRequest>
              <condPpalEsTomador>YES</condPpalEsTomador>
              <conductorUnico>NO</conductorUnico>
              <anosSegAnte>5</anosSegAnte>
              <nroCondOca>2</nroCondOca>
              <seguroEnVigor>YES</seguroEnVigor>
        </InsuranceRequest>';

        $this->assertXmlStringEqualsXmlString($xmlGenerator->generate($dto), $sampleOutput);
    }
}