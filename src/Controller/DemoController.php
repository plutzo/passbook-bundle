<?php

namespace Marlinc\PassbookBundle\Controller;

use Marlinc\PassbookBundle\GoogleWallet\Client;
use Marlinc\PassbookBundle\GoogleWallet\Helpers\IdGenerator;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Classes\LoyaltyClass;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections\InfoModuleData;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections\LabelValueRow;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections\LinksModuleData;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections\LocalizedString;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Barcode as GoogleBarcode;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Image as GoogleImage;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\ImageModuleData;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\ImageUri;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\LabelValue;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\LatLongPoint;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\LoyaltyPoints;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\LoyaltyPointsBalance;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Message;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\TextModuleData;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\TranslatedString;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Uri;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Objects\LoyaltyObject;
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
        $classResourcePayload = $this->makeLoyaltyClassResource($classId);
        $googleRestClient->insertLoyaltyClass($classResourcePayload);

        // This needs to be done once per issued wallet card.
        $objectId = IdGenerator::makeObjectId($googleRestClient->getConfig()->getIssuerId(), IdGenerator::TYPE_LOYALTY);
        $objectResourcePayload = $this->makeLoyaltyObjectResource($classId, $objectId);
        $googleRestClient->insertLoyaltyObject($objectResourcePayload);

        echo('<a href="' . $googleRestClient->generateDownloadLink($objectId) . '" target="_blank" />Save Loyalty Object</a>');

        die();
    }

    private function makeLoyaltyClassResource(string $classId): LoyaltyClass
    {
        $logoUri = new ImageUri();
        $logoUri->setUri("http://farm8.staticflickr.com/7340/11177041185_a61a7f2139_o.jpg");
        $logoUri->setDescription('Coffee beans');

        $logoImage = new \Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Image();
        $logoImage->setSourceUri($logoUri);

        $localOriginName = new LocalizedString();
        $localOriginNameTranslated = new TranslatedString();
        $localOriginNameTranslated->setLanguage("en-US");
        $localOriginNameTranslated->setValue("SFO Transit Center");
        $localOriginName->setDefaultValue($localOriginNameTranslated);


        $textModulesData = new TextModuleData();
        $textModulesData->setBody("Welcome to Baconrista rewards.");
        $textModulesData->setHeader("Rewards details");

        $locationUri = new Uri();
        $locationUri->setUri("http://maps.google.com/");
        $locationUri->setDescription("Nearby Locations");

        $telephoneUri = new Uri();
        $telephoneUri->setUri("tel:6505555555");
        $telephoneUri->setDescription("Call Customer Service");

        $linksModuleData = new LinksModuleData();
        $linksModuleData->setUris(array($locationUri, $telephoneUri));

        $imageUri = new ImageUri();
        $imageUri->setUri("http://farm4.staticflickr.com/3738/12440799783_3dc3c20606_b.jpg");
        $imageUri->setDescription("Baconrista Loyalty Image");
        $image = new GoogleImage();
        $image->setSourceUri($imageUri);
        $imageModulesData = new ImageModuleData();
        $imageModulesData->setMainImage($image);

        $location = new LatLongPoint();
        $location->setLatitude(37.424015499999996);
        $location->setLongitude(-122.09259560000001);


        $messageOne = new Message();
        $messageOne->setBody("Featuring our new bacon donuts.");
        $messageOne->setHeader("Welcome to Banconrista Rewards!");
        $messages = array($messageOne);


        $loyaltyClass = new LoyaltyClass();

        //required properties
        $loyaltyClass->setId($classId);
        $loyaltyClass->setIssuerName("Baconrista Coffee");
        $loyaltyClass->setProgramName("Baconrista Rewards");
        $loyaltyClass->setProgramLogo($logoImage);
        $loyaltyClass->setReviewStatus("underReview");
        // optional.  Check design and reference api to decide what's desirable
        $loyaltyClass->setImageModulesData($imageModulesData);
        $loyaltyClass->setLinksModuleData($linksModuleData);
        $loyaltyClass->setRewardsTier("Gold");
        $loyaltyClass->setRewardsTierLabel("Tier");
        $loyaltyClass->setLocations($location);
        $loyaltyClass->setMessages($messages);
        $loyaltyClass->setTextModulesData($textModulesData);


        return $loyaltyClass;

    }

    private function makeLoyaltyObjectResource(string $classId, string $objectId): LoyaltyObject
    {
        $barcode = new GoogleBarcode();
        $barcode->setType("qrCode");
        $barcode->setValue("1234abc");
        $barcode->setAlternateText("optional alternate text");

        $textModulesData = new TextModuleData();
        $textModulesData->setBody("Save more at your local Mountain View store Jane. " .
            " You get 1 bacon fat latte for every 5 coffees purchased.  " .
            "Also just for you, 10% off all pastries in the Mountain View store.");
        $textModulesData->setHeader("Jane\"s Baconrista Rewards");
        $textModulesDatas = $textModulesData;

        $accountUri = new Uri();
        $accountUri->setUri("http://wwww.google.com/");
        $accountUri->setDescription("My Baconrista Account");

        $linksModuleData = new LinksModuleData();
        $linksModuleData->setUris(array($accountUri));

        $location = new LatLongPoint();
        $location->setLatitude(37.424015499999996);
        $location->setLongitude(-122.09259560000001);
        $locations = array($location);

        $messageOne = new Message();
        $messageOne->setBody("Featuring our new bacon donuts.");
        $messageOne->setHeader("Thanks for joining our program. Show this message to " .
            "our barista for your first free coffee on us!");
        $messages = array($messageOne);

        $balance = new LoyaltyPointsBalance();
        $balance->setString("800");
        $loyaltyPoints = new LoyaltyPoints();
        $loyaltyPoints->setBalance($balance);
        $loyaltyPoints->setLabel("Points");

        $columnOne = new LabelValue();
        $columnOne->setLabel("Next Reward in");
        $columnOne->setValue("2 coffees");
        $columnTwo = new LabelValue();
        $columnTwo->setLabel("Member Since");
        $columnTwo->setValue("01/15/2013");
        $rowOne = new LabelValueRow();
        $rowOne->setColumns(array($columnOne, $columnTwo));
        $columnOneTwo = new LabelValue();
        $columnOneTwo->setLabel("Local Store");
        $columnOneTwo->setValue("Mountain");
        $rowTwo = new LabelValueRow();
        $rowTwo->setColumns(array($columnOneTwo));
        $infoModuleData = new InfoModuleData();
        $infoModuleData->setLabelValueRows(array($rowOne, $rowTwo));

        // Define loyalty object
        $payload = new LoyaltyObject();
        // required properties
        $payload->setClassId($classId);
        $payload->setId($objectId);
        $payload->setState("active");
        // optional.  Check design and reference api to decide what's desirable
        $payload->setBarcode($barcode);
        $payload->setAccountId("1234567890");
        $payload->setAccountName("Jane Doe");
        $payload->setTextModulesData($textModulesDatas);
        $payload->setLinksModuleData($linksModuleData);
        $payload->setLocations($locations);
        $payload->setMessages($messages);
        $payload->setLoyaltyPoints($loyaltyPoints);
        $payload->setInfoModuleData($infoModuleData);

        return $payload;
    }
}
