<?php

/**
 * @link: https://github.com/aztech/app-enlight-php-client
 * @link: http://appenlight.com
 * @package AppEnlight
 *
 * @author Tomasz Suchanek <tomasz.suchanek@gmail.com>
 */

/**
 * Application component for AppEnlight
 */
class AppEnlightApplicationComponent extends CApplicationComponent {

  /**
   * Your AppEnlight application API key
   * @var string
   */
  public $apiKey;

  /**
   * AppEnlight API version
   * @var string
   */
  public $apiVersion = '0.5';

  /**
   * Client from which we are logging/sending data
   * @var string
   */
  public $client;

  /**
   * Set http or https to use secure connection
   * @var string
   */
  public $scheme;

  /**
   * AppEnlight url address used to send data
   * @var string
   */
  public $url;

  /**
   * Client to handle all requests
   * @var \AppEnlight\Client
   */
  protected $_appenlightClient;

  public function init() {
    parent::init();
    $settings = new \AppEnlight\Settings();
    if (isset($this->apiKey)) {
      $settings->setApiKey($this->apiKey);
    }
    if (isset($this->client)) {
      $settings->setClient($this->client);
    }
    if (isset($this->scheme)) {
      $settings->setScheme($this->scheme);
    }
    if (isset($this->url)) {
      $settings->setUrl($this->url);
    }
    if (isset($this->apiVersion)) {
      $settings->setVersion($this->apiVersion);
    }
    $this->_appenlightClient = new \AppEnlight\Client($settings);
  }

  /**
   * @return \AppEnlight\Client
   */
  public function getClient() {
    return $this->_appenlightClient;
  }

  /**
   * @return \AppEnlight\Settings
   */
  public function getSettings() {
    $settings = new \AppEnlight\Settings();
    $settings->setApiKey($this->apiKey);
    $settings->setClient($this->client);
    $settings->setScheme($this->scheme);
    $settings->setUrl($this->url);
    $settings->setVersion($this->version);
    return $settings;
  }

  /**
   * Ensure that appenlight alias is loaded
   */
  protected function setRootAliasIfUndefined() {
    if (Yii::getPathOfAlias('appenlight') === false) {
      Yii::setPathOfAlias('appenlight', realpath(dirname(__FILE__) . '/..'));
    }
  }

  /**
   * If console application is running there is no information
   * about server name. Therefore gethostname() function is used
   * @return string
   */
  public function getHostName() {
    if (Yii::app() instanceof CConsoleApplication) {
      return gethostname();
    } else {
      return Yii::app()->getRequest()->getHostInfo();
    }
  }

  /**
   * Get username. In case the console application is running
   * "console" user name is returned. If user is logged in,
   * his name is returned. Otherwise "guest" is returned
   * @return string
   */
  public function getUsername() {
    if (Yii::app() instanceof CConsoleApplication) {
      return 'console';
    } else {
      return Yii::app()->user->isGuest ? 'guest' : Yii::app()->user->name;
    }
  }

}
