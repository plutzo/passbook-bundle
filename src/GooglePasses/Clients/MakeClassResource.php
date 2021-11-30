<?php


namespace Marlinc\PassbookBundle\GooglePasses\Clients;

use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Classes\LoyaltyClass;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections\InfoModuleData;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections\LabelValueRow;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections\LinksModuleData;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections\LocalizedString;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\Barcode;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\Image;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\ImageModuleData;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\ImageUri;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\LabelValue;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\LatLongPoint;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\LoyaltyPoints;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\LoyaltyPointsBalance;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\Message;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\TextModuleData;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\TranslatedString;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\Uri;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Objects\LoyaltyObject;

class MakeClassResource
{

    public static function makeLoyaltyClassResource($classId)
    {
        $logoUri = new ImageUri();
        $logoUri->setUri("http://farm8.staticflickr.com/7340/11177041185_a61a7f2139_o.jpg");
        $logoUri->setDescription('Coffee beans');
        $logoImage = new Image();
        $logoImage->setSourceUri($logoUri);

        $localOriginName = new LocalizedString();
        $localOriginNameTranslated = new TranslatedString();
        $localOriginNameTranslated->setLanguage("en-US");
        $localOriginNameTranslated->setValue("SFO Transit Center");
        $localOriginName->setDefaultValue($localOriginNameTranslated);


        $textModulesData = new TextModuleData();
        $textModulesData->setBody("Welcome to Baconrista rewards. ");
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
        $image = new Image();
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

    public static function makeLoyaltyObjectResource($classId, $objectId)
    {

        $barcode = new Barcode();
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


        $rowOne = new LabelValueRow();

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