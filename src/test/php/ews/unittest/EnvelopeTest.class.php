<?php namespace ews\unittest;

use ews\Envelope;
use ews\Header;
use ews\Body;
use ews\types\ServerVersionInfo;
use ews\types\RequestServerVersion;
use ews\messages\FindItemResponse;
use xml\XMLFormatException;
use lang\IllegalArgumentException;

class EnvelopeTest extends \unittest\TestCase {

  /**
   * Returns an envelope consisting of header and a given body as string
   *
   * @param  string $body
   * @return string
   */
  private function envelope($body= '') {
    return sprintf('<?xml version="1.0" encoding="UTF-8"?>
      <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
        <s:Header>  
          <h:ServerVersionInfo
           MajorVersion="15"
           MinorVersion="0"
           MajorBuildNumber="1236"
           MinorBuildNumber="1"
           Version="V2_23"
           xmlns:h="http://schemas.microsoft.com/exchange/services/2006/types"
           xmlns="http://schemas.microsoft.com/exchange/services/2006/types"
           xmlns:xsd="http://www.w3.org/2001/XMLSchema"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          />
        </s:Header>
        <s:Body>%s</s:Body>
      </s:Envelope>',
      $body
    );
  }

  #[@test]
  public function parse_header() {
    $this->assertEquals(
      (new ServerVersionInfo())->pass([
        'MajorVersion'     => '15',
        'MinorVersion'     => '0',
        'MajorBuildNumber' => '1236',
        'MinorBuildNumber' => '1',
        'Version'          => 'V2_23'
      ]),
      Envelope::parse($this->envelope())->header()->serverVersionInfo()
    );
  }

  #[@test]
  public function parse_response() {
    $response= '
      <m:FindItemResponse xmlns:m="http://schemas.microsoft.com/exchange/services/2006/messages">
        <m:ResponseMessages>
          <m:FindItemResponseMessage ResponseClass="Success"/>        
        </m:ResponseMessages>
      </m:FindItemResponse>
    ';

    $this->assertInstanceOf(FindItemResponse::class, Envelope::parse($this->envelope($response))->body()->message());
  }

  #[@test]
  public function parse_response_namespace_handling() {
    $response= '
      <m:FindItemResponse xmlns:m="http://schemas.microsoft.com/exchange/services/2006/messages">
        <ResponseMessages xmlns="http://schemas.microsoft.com/exchange/services/2006/messages">
          <FindItemResponseMessage ResponseClass="Success"/>
        </ResponseMessages>
      </m:FindItemResponse>
    ';

    $this->assertInstanceOf(FindItemResponse::class, Envelope::parse($this->envelope($response))->body()->message());
  }

  #[@test, @expect(XMLFormatException::class)]
  public function parse_invalid() {
    Envelope::parse('this.is.not.xml');
  }

  #[@test]
  public function emit_default() {
    $envelope= (new Envelope())->with(new Header(new RequestServerVersion('Exchange2010_SP1')))->with(new Body());

    $this->assertEquals(
      str_replace("\n        ", "\n", trim('
        <?xml version="1.0" encoding="UTF-8"?>
        <s:Envelope
         xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"
         xmlns:t="http://schemas.microsoft.com/exchange/services/2006/types"
         xmlns:m="http://schemas.microsoft.com/exchange/services/2006/messages"
        >
          <s:Header>  
            <t:RequestServerVersion Version="Exchange2010_SP1"/>
          </s:Header>
          <s:Body/>
        </s:Envelope>
     ')),
      trim($envelope->emit())
    );
  }

  #[@test]
  public function emit_compact() {
    $envelope= (new Envelope())->with(new Header(new RequestServerVersion('Exchange2010_SP1')))->with(new Body());

    $this->assertEquals(
      '<s:Envelope'.
      ' xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"'.
      ' xmlns:t="http://schemas.microsoft.com/exchange/services/2006/types"'.
      ' xmlns:m="http://schemas.microsoft.com/exchange/services/2006/messages"'.
      '>'.
      '<s:Header><t:RequestServerVersion Version="Exchange2010_SP1"></t:RequestServerVersion></s:Header>'.
      '<s:Body></s:Body>'.
      '</s:Envelope>',
      $envelope->emit(Envelope::COMPACT)
    );
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function emit_invalid() {
    (new Envelope())->emit('invalid.style');
  }
}