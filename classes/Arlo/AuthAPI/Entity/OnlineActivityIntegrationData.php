<?php namespace enrol_arlo\Arlo\AuthAPI\Entity;

use enrol_arlo\Arlo\AuthAPI\Enum\IntegrationData;
use GuzzleHttp\Psr7\Uri;

class OnlineActivityIntegrationData {

    private $EditUri;

    private $Link;

    public function getVendorID() {
        return IntegrationData::VendorID;
    }

    public function getEditUri($toString = true) {
        if ($toString) {
            return (string) $this->EditUri;
        }
        return $this->EditUri;
    }

    public function setEditUri(string $uri) {
        $this->EditUri = new Uri($uri);
    }

    public function setLink(Link $link) {

    }
}
