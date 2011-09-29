<?php

/**
 * URL Router class
 *
 * @see http://blog.sosedoff.com/2009/07/04/simpe-php-url-routing-controller/
 */
class Router {
  use Singleton;

  static protected $controller;
  static protected $action;
  static protected $params = array();
  static protected $rules = array();

  private static function arrayClean($array) {
    foreach($array as $key => $value) {
      if (strlen($value) == 0) unset($array[$key]);
    }
  }

  private static function ruleMatch($rule, $data) {
    $ruleItems = explode('/',$rule); self::arrayClean($ruleItems);
    $dataItems = explode('/',$data); self::arrayClean($dataItems);

    if (count($ruleItems) == count($dataItems)) {
      $result = array();

      foreach($ruleItems as $ruleKey => $ruleValue) {
        if (preg_match('/^:[\w]{1,}$/',$ruleValue)) {
          $ruleValue = substr($ruleValue,1);
          $result[$ruleValue] = $dataItems[$ruleKey];
        }
        else {
          if (strcmp($ruleValue,$dataItems[$ruleKey]) != 0) {
            return false;
          }
        }
      }

      if (count($result) > 0) return $result;
      unset($result);
    }
    return false;
  }

  private static function defaultRoutes($url) {
    // process default routes
    $items = explode('/',$url);

    // remove empty blocks
    foreach($items as $key => $value) {
      if (strlen($value) == 0) unset($items[$key]);
    }

    // extract data
    if (count($items)) {
      self::$controller = array_shift($items);
      self::$action = array_shift($items);
      self::$params = $items;
    }
  }

  public static function init() {
    $url = $_SERVER['REQUEST_URI'];
    $isCustom = false;

    if (count(self::$rules)) {
      foreach(self::$rules as $ruleKey => $ruleData) {
        $params = self::ruleMatch($ruleKey,$url);
        if ($params) {
          self::$controller = 'Controller_'.$ruleData['controller'];
          self::$action = 'action_'.$ruleData['action'];
          self::$params = $params;
          $isCustom = true;
          break;
        }
      }
    }

    if (!$isCustom) self::defaultRoutes($url);

    if (!strlen(self::$controller)) self::$controller = 'Controller_Main';
    if (!strlen(self::$action)) self::$action = 'action_index';
  }

  public static function addRule($rule, $target) {
    self::$rules[$rule] = $target;
  }


  public static function getController() { return self::$controller; }
  public static function getAction() { return self::$action; }
  public static function getParams() { return self::$params; }
  public static function getParam($id) { return self::$params[$id]; }
}
