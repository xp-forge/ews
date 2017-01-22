Exchange Webservices change log
===============================

## ?.?.? / ????-??-??

## 0.2.0 / 2017-01-22

* Made supplying well-known `/EWS/Exchange.asmx` path in `ews.ExchangeService`
  constructor optional.
  @thekid
* Added support for timezone context, which is necessary for e.g. Free/Busy.
  Use local timezone via `util.TimeZone::getLocal()` by default. See issue #1
  and https://msdn.microsoft.com/en-us/library/office/ff406132(v=exchg.140).aspx
  (@thekid)

## 0.1.0 / 2017-01-22

* Hello World! First release - @thekid