<?php

namespace App\Tests\Unit\Module\Insurance\Infrastructure\Generator;

use App\Module\Insurance\Domain\Insurer\Entities\DatosConductor;
use App\Module\Insurance\Domain\Insurer\Entities\InsuranceProviderRequest;
use App\Module\Insurance\Infrastructure\Generators\XmlGenerator;
use PHPUnit\Framework\TestCase;

class XmlGeneratorTest extends TestCase
{
    public function test_it_should_create_xml_string()
    {
        $datosRequest = DatosConductor::CreateFromArray([
            'condPpalEsTomador' => 'YES',
            'conductorUnico' => 'NO',
            'fecCot' => '2025-02-14',
            'anosSegAnte' => 5,
            'nroCondOca' => 2,
            'seguroEnVigor' => 'YES',
        ]);

        $insuranceRequest = new InsuranceProviderRequest($datosRequest);
        $xmlGenerator = new XmlGenerator();

        $sampleOutput = '<?xml version="1.0" encoding="UTF-8"?>
            <TarificacionThirdPartyRequest>
              <Datos>
                <DatosConductor>
                  <CondPpalEsTomador>YES</CondPpalEsTomador>
                  <ConductorUnico>NO</ConductorUnico>
                  <FecCot>2025-02-14</FecCot>
                  <AnosSegAnte>5</AnosSegAnte>
                  <NroCondOca>2</NroCondOca>
                  <SeguroEnVigor>YES</SeguroEnVigor>
                </DatosConductor>
              </Datos>
            </TarificacionThirdPartyRequest>';

        $this->assertXmlStringEqualsXmlString($xmlGenerator->generate($insuranceRequest), $sampleOutput);
    }
}