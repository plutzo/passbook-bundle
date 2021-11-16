<?php

namespace Marlinc\PassbookBundle\Controller;

use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Image;
use Passbook\Pass\Structure;
use Passbook\Type\EventTicket;
use Passbook\PassFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Marlinc\PassbookBundle\Services\IosPassBook;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * @Route("/passbook/sample", name="passbook_sample" , methods={"GET","HEAD"} )
     */
    public function indexAction(PassFactory $passFactory)
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
}
