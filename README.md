# PassbookBundle

PassbookBundle integrates the [php-passbook](http://eymengunay.github.io/php-passbook) library into Symfony. 

**Note**: See php-passbook documentation for more information on obtaining your p12 and wwdr certificates.

## Prerequisites
This version of the bundle requires Symfony 2.1+

## Installation

### Step 1: Download PassbookBundle using composer

```
$ composer require marlinc/passbook-bundle
```
Composer will install the bundle to your project's vendor/marlinc directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:
```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Eo\PassbookBundle\EoPassbookBundle(),
    );
}
```

### Step 3: Configure the bundle

Now that you have properly installed and enabled PassbookBundle, the next step is to configure the bundle 
to work with the specific needs of your application.

Add the following configuration to your `config.yml` file
```
# app/config/config.yml
marlinc_passbook:
    pass_type_identifier:       PASS-TYPE-IDENTIFIER
    team_identifier:            TEAM-IDENTIFIER
    organization_name:          ORGANIZATION-NAME
    p12_certificate:            /path/to/p12/certificate
    p12_certificate_password:   P12-CERTIFICATE-PASSWORD
    wwdr_certificate:           /path/to/wwdr/certificate
    output_path:                /path/to/save/pkpass
    icon_file:                  /path/to/iconfile
```
All configuration values are required to use the bundle.

### Step 4 (Optional): Import PassbookBundle routing files

To browse the simple usage example you have to import the following file in your `routing.yml`:

```
# app/config/routing.yml
eo_passbook_sample:
    resource: "@EoPassbookBundle/Resources/config/routing/sample.xml"
```

You will now be able to access the example controller from: `http://domain.tld/passbook/sample`


## Usage

This bundle currently adds only a single service, `pass_factory`
```
// Getting pass_factory service is straightforward:
$factory = $this->get('pass_factory');
```

See php-passbook documentation for the rest.

The following documents are available:
* [PHP-Passbook Documentation](http://eymengunay.github.io/php-passbook)
* [PHP-Passbook API DOC](http://eymengunay.github.io/php-passbook/api)
