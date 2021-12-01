# MarlincPassbookBundle

[![Build Status](https://travis-ci.org/eymengunay/PassbookBundle.png)](https://travis-ci.org/eymengunay/PassbookBundle)
[![Latest Stable Version](https://poser.pugx.org/eo/passbook-bundle/v/stable.png)](https://packagist.org/packages/eo/passbook-bundle)
[![Total Downloads](https://poser.pugx.org/eo/passbook-bundle/downloads.png)](https://packagist.org/packages/eo/passbook-bundle)

[![knpbundles.com](http://knpbundles.com/eymengunay/PassbookBundle/badge-short)](http://knpbundles.com/eymengunay/PassbookBundle)

MarlincPassbookBundle for using the EoPassbookBundle library and GooglePass library. 

**Note**: See php-passbook documentation for more information on obtaining your p12 and wwdr certificates.

## Prerequisites
This version of the bundle requires Symfony 5.3+

## Installation

### Step 1: Download EoPassbookBundle using composer
Add MarlincPassbookBundle in your composer.json:
```
{
    "require": {
        "marlinc/passbook-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:
```
$ php composer require marlinc/passbook-bundle
```
Composer will install the bundle to your project's vendor/eo directory.

### Step 2: Configure the MarlincPassbookBundle
Now that you have properly installed and enabled MarlincPassbookBundle, the next step is to configure the bundle to work with the specific needs of your application.

Add the following configuration to your `marlinc_passbook.yaml` file
```
# app/config/packages/marlinc_passbook.yaml

marlinc_passbook:
    marlinc_passbook_ios:
        pass_type_identifier:           PASS-TYPE-IDENTIFIER
        team_identifier:                TEAM-IDENTIFIER
        organization_name:              ORGANIZATION-NAME
        p12_certificate:                /path/to/p12/certificate
        p12_certificate_password:       P12-CERTIFICATE-PASSWORD
        wwdr_certificate:               /path/to/wwdr/certificate
        output_path:                    /path/to/save/pkpass
        icon_file:                      /path/to/iconfile
    marlinc_passbook_google:
        service_account_email_address:  ACCOUNT-EMAIL
        service_account_file:           /path/to/account_file
        application_name:               APPLICATION_NAME
        issuser_id:                     ISSUSER-ID
        origins:                        ['http://localhost:8000']
        scopes:                         ['https://www.googleapis.com/auth/wallet_object.issuer']
        save_link:                      'https://pay.google.com/gp/v/save/'
        
```
All configuration values are required to use the bundle.

### Step 3 (Optional): Import MarlincPassbookBundle routing files
To browse the simple usage example you have to import the following file in your `routing.yml`:
```
# app/config/routing.yml

MarlincPassbookBundle:
  resource: "@MarlincPassbookBundle/Controller/"
  type:     annotation
  
```
You will now be able to access the example controller from: `http://domain.tld/passbook/sample`

### Step 4 : Add MarlincPassbookBundle Controller as service in services.yaml
```
# app/config/services.yaml

    Marlinc\PassbookBundle\Controller\:
        resource: '@MarlincPassbookBundle/Controller/*'
        calls:
            - [ setContainer,[ '@service_container' ] ]
```
## Usage

This bundle currently adds only a single service, `pass_factory` for EoPassbookBundle
```
Marlinc\PassbookBundle\Controller\DemoController.php
```

See php-passbook documentation for the rest.

The following documents are available:
* [PHP-Passbook Documentation](http://eymengunay.github.io/php-passbook)
* [PHP-Passbook API DOC](http://eymengunay.github.io/php-passbook/api)
* [Google Pay API for Passes](https://developers.google.com/pay/passes/guides/introduction/about-google-pay-api-for-passes)

## License
This bundle is under the MIT license. See the complete license in the bundle:
```
Resources/meta/LICENSE
```

## Reporting an issue or a feature request
Issues and feature requests related to this bundle are tracked in the Github issue tracker https://github.com/eymengunay/PassbookBundle/issues. PHP-Passbook related issues and requests should be opened under php-passbook library repository: https://github.com/eymengunay/php-passbook/issues
