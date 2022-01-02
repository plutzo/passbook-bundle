<?php

namespace Marlinc\PassbookBundle\Controller;

use Marlinc\PassbookBundle\GoogleWallet\Client;
use Marlinc\PassbookBundle\GoogleWallet\Helpers\IdGenerator;
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
        $pass = new EventTicket("123456" . random_int(1000, 9999), "The Beat Goes On");
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
        $icon = new Image($this->container->getParameter('marlinc_passbook.apple.icon_file'), 'icon');
        $pass->addImage($icon);

        // Set pass structure
        $pass->setStructure($structure);

        // Add barcode
        $barcode = new Barcode(Barcode::TYPE_QR, 'barcodeMessage');
        $pass->addBarcode($barcode);

        // Pakcage + return pass.
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
    public function googleAction(Client $googleRestClient)
    {
        // This needs to be done only once per loyalty program.
        $classId = IdGenerator::makeClassId($googleRestClient->getConfig()->getIssuerId(), IdGenerator::TYPE_LOYALTY);
        $classResourcePayload = DemoResources::makeLoyaltyClassResource($classId);
        $googleRestClient->insertLoyaltyClass($classResourcePayload);

        // This needs to be done once per issued wallet card.
        $objectId = IdGenerator::makeObjectId($googleRestClient->getConfig()->getIssuerId(), IdGenerator::TYPE_LOYALTY);
        $objectResourcePayload = DemoResources::makeLoyaltyObjectResource($classId, $objectId);
        $googleRestClient->insertLoyaltyObject($objectResourcePayload);

        echo('<a href="' . $googleRestClient->generateDownloadLink($objectId) . '" target="_blank" />Save Loyalty Object</a>');

        die();
    }
}
