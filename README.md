Exchange Webservices for the XP Framework
=========================================

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-forge/ews.svg)](http://travis-ci.org/xp-forge/ews)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.6+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_6plus.png)](http://php.net/)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Supports HHVM 3.5+](https://raw.githubusercontent.com/xp-framework/web/master/static/hhvm-3_5plus.png)](http://hhvm.com/)
[![Latest Stable Version](https://poser.pugx.org/xp-forge/ews/version.png)](https://packagist.org/packages/xp-forge/ews)

XP Framework implementation of Microsoft's [EWS Managed API](https://msdn.microsoft.com/en-us/library/office/dn567668%28v=exchg.150%29.aspx)

Entry point
-----------

```php
use ews\ExchangeService;

$ews= new ExchangeService('https://user:pass@owa.example.com/');
$result= $ews->invoke(...);
```

TimeZones
---------

By default, the local timezone determined via `TimeZone::getLocal()` is used as context for all requests. This may be changed:

```php
// Use an Olson identifier or a Windows timezone ID
$ews->useTimeZone('Europe/Berlin');
$ews->useTimeZone('W. Europe Standard Time');

// ...or a TimeZone instance
$ews->useTimeZone(TimeZone::getLocal());
```

*:warning: This is work in progress!*