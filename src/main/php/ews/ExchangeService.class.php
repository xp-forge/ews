<?php namespace ews;

use peer\URL;
use ews\types\RequestServerVersion;
use ews\errors\FaultNamed;
use lang\reflect\Package;
use util\TimeZone;

/**
 * Exchange Service entry point class
 *
 * @ext  curl Uses CURL as long as xp-framework/http doesn't support NTLM
 * @see  https://msdn.microsoft.com/en-us/library/office/dn567668(v=exchg.150).aspx
 */
class ExchangeService implements \util\log\Traceable {
  private static $errors;
  private $handle, $version;
  private $trace= null;
  private $timeZone= null;

  static function __static() {
    self::$errors= Package::forName('ews.errors');
  }

  /**
   * Creates an ExchangeService instance with which EWS APIs can be invoked.
   *
   * @param  string|peer.URL $endpoint
   * @param  string $version
   */
  public function __construct($endpoint, $version= 'Exchange2010_SP1') {
    $url= $endpoint instanceof URL ? $endpoint : new URL($endpoint);
    $this->handle= curl_init($url->getURL());
    curl_setopt_array($this->handle, [
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST           => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_HTTPAUTH       => CURLAUTH_NTLM
    ]);
    $this->version= new RequestServerVersion($version);
    $this->useTimeZone(TimeZone::getLocal());
  }

  /**
   * Sets a trace for logging
   *
   * @param  util.log.LogCategory $cat
   */
  public function setTrace($cat) {
    $this->trace= $cat;
  }

  /**
   * Use a given timezone
   *
   * @param  string|util.TimeZone $timeZone
   * @return self This
   */
  public function useTimeZone($timeZone) {
    if ($timeZone instanceof TimeZone) {
      $id= TimeZones::named($timeZone->getName());
    } else {
      $id= TimeZones::named($timeZone, $timeZone);
    }

    $this->timeZone= Object::typed('ews.types.TimeZoneContext')
      ->with(Object::typed('ews.types.TimeZoneDefinition', ['Id' => $id]))
    ;
    return $this;
  }

  /**
   * Invoke 
   *
   * @param  ews.Element $message
   * @return ews.Element
   * @throws ews.errors.Fault
   */
  public function invoke($message) {
    $request= new Envelope(new Header($this->version, $this->timeZone), new Body($message));
    curl_setopt($this->handle, CURLOPT_HTTPHEADER, [
      'Connection: Keep-Alive',
      'User-Agent: XP/ews',
      'Content-Type: text/xml; charset=utf-8',
    ]);
    curl_setopt($this->handle, CURLOPT_POSTFIELDS, $request->emit(Envelope::COMPACT));

    $this->trace && $this->trace->info('>>> ', $request->emit());
    if (false === ($response= curl_exec($this->handle))) {
      throw new FaultNamed('I/O#'.curl_errno($this->handle), curl_error($this->handle));
    }

    $info= curl_getinfo($this->handle);
    $this->trace && $this->trace->info('<<< ', $info['http_code'], ' ', $response);

    // Handle errors other than SOAP faults, e.g. 404
    if (200 !== $info['http_code'] && !strstr($info['content_type'], 'xml')) {
      throw new FaultNamed('HTTP#'.$info['http_code'], $response);
    }

    $envelope= Envelope::parse($response);
    if ($fault= $envelope->fault()) {
      $faultCode= $fault->code();
      if (self::$errors->providesClass($faultCode)) {
        throw self::$errors->loadClass($faultCode)->newInstance($fault->detail()->toString());
      } else {
        throw new FaultNamed($faultCode, $fault->detail()->toString());
      }
    }

    return $envelope->body()->message();
  }

  /** @return void */
  public function __destruct() {
    curl_close($this->handle);
  }
}