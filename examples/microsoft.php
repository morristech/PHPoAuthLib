<?php
/**
 * Example of retrieving an authentication token of the Microsoft service
 *
 * PHP version 5.4
 *
 * @author     David Desberg <david@daviddesberg.com>
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
use OAuth\OAuth2\Service\Microsoft;
use OAuth\Common\Storage\Memory;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\Uri;

/**
 * Bootstrap the example
 */
require_once __DIR__ . '/bootstrap.php';

// In-memory storage
$storage = new Memory();

// Setup the credentials for the requests
$credentials = new Credentials(
    $servicesCredentials['microsoft']['key'],
    $servicesCredentials['microsoft']['secret'],
    $currentUri->getAbsoluteUri()
);

// Instantiate the google service using the credentials, http client and storage mechanism for the token
/** @var $microsoft Microsoft */
$microsoft = $serviceFactory->createService('microsoft', $credentials, $storage, [ 'basic' ]);

if( !empty( $_GET['code'] ) ) {
    // This was a callback request from google, get the token
    $token = $microsoft->requestAccessToken( $_GET['code'] );

    var_dump($token);

} elseif( !empty($_GET['go'] ) && $_GET['go'] == 'go' ) {
    $url = $microsoft->getAuthorizationUri();
    header('Location: ' . $url);
} else {
    $url = $currentUri->getRelativeUri() . '?go=go';
    echo "<a href='$url'>Login with Microsoft!</a>";
}