<?php

namespace Marlinc\PassbookBundle\Controller;

use Marlinc\PassbookBundle\GooglePasses\Clients\GoogleRestClient;
use Marlinc\PassbookBundle\GooglePasses\Clients\MakeClassResource;
use Marlinc\PassbookBundle\GooglePasses\Helpers\GpapJwt;
use Marlinc\PassbookBundle\GooglePasses\Helpers\JwtPayload;
use Marlinc\PassbookBundle\GooglePasses\Helpers\Settings;
use Marlinc\PassbookBundle\Services\IosPassBook;
use Passbook\Pass\Barcode;
use Passbook\Pass\Field;
use Passbook\Pass\Image;
use Passbook\Pass\Structure;
use Passbook\PassFactory;
use Passbook\Type\EventTicket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


class DemoController extends AbstractController
{
    /**
     * @Route("iso/passbook/sample", name="ios_passbook_sample" , methods={"GET","HEAD"} )
     */
    public function iosAction(PassFactory $passFactory)
    {
        $pass = new EventTicket("123456".rand(1000,9999), "The Beat Goes On");
        $pass->setBackgroundColor('rgb(60, 65, 76)');
        $pass->setLogoText('Apple Inc.');


        // Create pass structure
        $structure = new Structure();

// Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

// Add secondary field
        $secondary = new Field('location', 'Moscone West');
        $secondary->setLabel('Location');
        $structure->addSecondaryField($secondary);

// Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

// Add icon image
        $icon = new Image($this->container->getParameter('marlinc_passbook_ios.icon_file'), 'icon');
        $pass->addImage($icon);

// Set pass structure
        $pass->setStructure($structure);

// Add barcode
        $barcode = new Barcode(Barcode::TYPE_QR, 'barcodeMessage');
        $pass->setBarcode($barcode);

// Create pass factory instance

        return new BinaryFileResponse(
            $passFactory->package($pass),
            200,
            [
                'Content-Type' => 'application/vnd.apple.pkpass'
            ],
            true,
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
    }

    /**
     * @Route("google/passbook/sample", name="google_passbook_sample" , methods={"GET","HEAD"} )
     */
    public function googleAction(GoogleRestClient $googleRestClient)
    {
        $classId = Settings::makeClassId($googleRestClient->config->getIssuerId(), Settings::TYPE_LOYALTY, []);

        $objectId = Settings::makeObjectId($googleRestClient->config->getIssuerId(), Settings::TYPE_LOYALTY, []);

        $classResourcePayload = MakeClassResource::makeLoyaltyClassResource($classId);

        $objectResourcePayload = MakeClassResource::makeLoyaltyObjectResource($classId, $objectId);

        $classResponse = $googleRestClient->insertLoyaltyClass($classResourcePayload);
        $objectResponse = $googleRestClient->insertLoyaltyObject($objectResourcePayload);

        $googleRestClient->handleInsertCallStatusCode($classResponse, "class", $classId, NULL);

        // check object insert response. Will print out if object insert succeeds or not. Throws error if object resource is malformed, or if existing objectId's classId does not match the expected classId
        $googleRestClient->handleInsertCallStatusCode($objectResponse, "object", $objectId, $classId);

        $googlePassJwt = new GpapJwt($googleRestClient->config->getServiceAccountEmail(), $googleRestClient->config->getPrivateKey(), $googleRestClient->config->getOrigins());

        $jwtPayload = new JwtPayload();
        $jwtPayload->addLoyaltyObject(array("id" => $objectId));
        $signedJwt = $googlePassJwt->generateSignedJwt($jwtPayload);
        dump($signedJwt);

        echo('<a href="' . $googleRestClient->config->getSaveLink() . $signedJwt . '" target="_blank" />Save Loyalty Object</a>');

        die();
    }
}
