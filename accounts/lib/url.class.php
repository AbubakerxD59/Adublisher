<?php
  /**
   * Url Class
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2020
   * @version $Id: url.class.php, v1.00 2020-04-20 18:20:24 gewa Exp $
   */

  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

  class Url
  {
	  
	  public static $data = array();

      /**
       * Url::__construct()
       * 
       * @return
       */
      public function __construct()
      {

      }

      /**
       * Url::redirect()
       * 
       * @param mixed $location
       * @return
       */
      public static function redirect($location)
      {
          if (!headers_sent()) {
              header('Location: ' . $location);
              exit;
          } else
              echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
      }

      /**
       * Url::protocol()
       * 
       * @return
       */
      public static function protocol()
      {
          if (isset($_SERVER['HTTPS'])) {
              $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
          } elseif(isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
			  $protocol = 'https';
		  } else {
              $protocol = 'http';
          }

          return $protocol;
      }

      /**
       * Url::url()
       * 
       * @param mixed $path
       * @param bool $pars
       * @return
       */
      public static function url($path, $pars = false)
      {
          $param = ($pars) ? $pars : null;

          return SITEURLMM . $path . '/' . $param;
      }

      /**
       * Url::segment()
       * 
	   * @param mixed $segment
       * @return
       */
      public static function segment($segment)
      {
          if (isset($segment[2])) {
              $action = $segment[2] ? $segment[2] : false;

              if ($action == false) {
                  Message::invalid("Action Method" . $action);
              } else
                  return $action;
          }
      }

      /**
       * Url::crumbs()
       * 
       * @param mixed $url
	   * @param mixed $pointer
	   * @param mixed $home
       * @return $string
       */
	  public static function crumbs($url, $pointer, $home)
	  {
	
		  $array_keys = array_keys($url);
		  $last_key = end($array_keys);
		  reset($url);
		  $last_segment = '';
		  $breadcrumbs = '';
	
		  $only = count($url);
		  if ($only == 1) {
			  $breadcrumbs = '<div class="active section">' . $home . '</div>';
		  } else {
			  foreach ($url as $key => $part) {
				  $last_segment .= '/' . $part;
				  if ($key != 0) {
					  $breadcrumbs .= '<span class="divider">' . $pointer . '</span>';
				  }
	
				  if ($key == $last_key) {
					  $breadcrumbs .= '<div class="active section">' . ucwords($part) . '</div>';
				  } else {
					  $breadcrumbs .= '<a href="' . SITEURLMM . '/' . substr($last_segment, 1) . '/" class="section">' . ucwords(str_replace($url[0], $home, $part)) . '</a>';
				  }
	
			  }
		  }
	
		  return $breadcrumbs;
	
	  }

      /**
       * Url::isPartSet()
       * 
       * @param mixed $segment
	   * @param mixed $part
       * @param mixed $page
       * @return
       */
      public static function isPartSet($segment, $part, $page)
      {
          return (isset($segment[$part]) and in_array($segment[$part], $page)) ? true : false;

      }
	  
	  /**
	   * Url::in_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public static function in_url($data)
	  {
		  $display = str_replace("../uploads/", "uploads/", $data);
		  return $display;  
	  }

	  /**
	   * Url::out_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public static function out_url($data)
	  {
		  $display = str_replace("uploads/", "../uploads/", $data); 
		  return $display; 
	  }
	  
      /**
       * Url::getIP()
       * 
       * @return
       */
	  public static function getIP() {
		  $ipaddress = '';
		  if (getenv('HTTP_CLIENT_IP'))
			  $ipaddress = getenv('HTTP_CLIENT_IP');
		  else if(getenv('HTTP_X_FORWARDED_FOR'))
			  $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		  else if(getenv('HTTP_X_FORWARDED'))
			  $ipaddress = getenv('HTTP_X_FORWARDED');
		  else if(getenv('HTTP_FORWARDED_FOR'))
			  $ipaddress = getenv('HTTP_FORWARDED_FOR');
		  else if(getenv('HTTP_FORWARDED'))
			 $ipaddress = getenv('HTTP_FORWARDED');
		  else if(getenv('REMOTE_ADDR'))
			  $ipaddress = getenv('REMOTE_ADDR');
		  else
			  $ipaddress = 'UNKNOWN';
			  
		  return Validator::sanitize($ipaddress);
	  }
  
      /**
       * Url::doSeo()
       * 
       * @param mixed $string
       * @return $string
       */
      public static function doSeo($string, $maxlen = 0)
      {
          $newStringTab = array();
          $string = Validator::cleanOut($string);
          $string = strtolower(self::doChars($string));
          $stringTab = str_split($string);
          $numbers = array(
              "0",
              "1",
              "2",
              "3",
              "4",
              "5",
              "6",
              "7",
              "8",
              "9",
              "-");

          foreach ($stringTab as $letter) {
              if (in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
                  $newStringTab[] = $letter;
              } elseif ($letter == " ") {
                  $newStringTab[] = "-";
              }

          }

          if (count($newStringTab)) {
              $newString = implode($newStringTab);
              if ($maxlen > 0) {
                  $newString = substr($newString, 0, $maxlen);
              }

              $newString = self::remDupes('--', '-', $newString);
          } else {
              $newString = '';
          }

          return $newString;

      }

      /**
       * Url::sortItems()
       * 
	   * @param mixed $url
	   * @param mixed $action
       * @return
       */
      public static function sortItems($url, $action)
      {
          if(isset($_GET[$action])) {
			  $data = explode("|", $_GET[$action]);
			  if($data && count($data) == 2) {
				  $result = ($data[1] == "DESC") ? "ASC" : "DESC";
				  return $url . "?$action=" . $data[0] . "|" . $result;
			  }
		  }
      }
	  
      /**
       * Url::setActive()
       * 
	   * @param mixed $action
	   * @param mixed $name
       * @return
       */
      public static function setActive($action, $name)
      {
          if(isset($_GET[$action])) {
			  $data = explode("|", $_GET[$action]);
			  if($data && count($data) == 2) {
				  return ($data[0] == $name) ? " active" : "";
			  }
		  } elseif(empty($_GET[$action]) and $name == false){
			  return " active";
		  }
      }
	  
      /**
       * Url::buildUrl()
       * 
	   * @param mixed $key
	   * @param mixed $value
	   * @param mixed $option
       * @return
       */
	  public static function buildUrl($key, $value, $option = "filter")
	  {
		  $parts = parse_url($_SERVER['REQUEST_URI']);
		  if (isset($parts['query'])) {
			  parse_str($parts['query'], $qs);
		  } else {
			  $qs = array();
		  }
		  $qs[$option] = "true";
		  $qs[$key] = $value;
		  return "?" . $parts['query'] = http_build_query($qs);
	  }

      /**
       * Url::thisUrl()
       * 
       * @return
       */
	  public static function thisUrl()
	  {
		  return SITEURLMM . $_SERVER['REQUEST_URI'];
	  }
	  
      /**
       * Url::remDupes()
       * 
       * @param mixed $sSearch
       * @param mixed $sReplace
       * @param mixed $sSubject
       * @return
       */
      private static function remDupes($sSearch, $sReplace, $sSubject)
      {
          $i = 0;
          do {

              $sSubject = str_replace($sSearch, $sReplace, $sSubject);
              $pos = strpos($sSubject, $sSearch);

              $i++;
              if ($i > 100) {
                  die('remDupes() loop error');
              }

          } while ($pos !== false);

          return $sSubject;
      }

      /**
       * Url::doChars()
       * 
       * @param mixed $string
       * @return
       */
      private static function doChars($string)
      {
          //cyrylic transcription
          $cyrylicFrom = array(
              'А',
              'Б',
              'В',
              'Г',
              'Д',
              'Е',
              'Ё',
              'Ж',
              'З',
              'И',
              'Й',
              'К',
              'Л',
              'М',
              'Н',
              'О',
              'П',
              'Р',
              'С',
              'Т',
              'У',
              'Ф',
              'Х',
              'Ц',
              'Ч',
              'Ш',
              'Щ',
              'Ъ',
              'Ы',
              'Ь',
              'Э',
              'Ю',
              'Я',
              'а',
              'б',
              'в',
              'г',
              'д',
              'е',
              'ё',
              'ж',
              'з',
              'и',
              'й',
              'к',
              'л',
              'м',
              'н',
              'о',
              'п',
              'р',
              'с',
              'т',
              'у',
              'ф',
              'х',
              'ц',
              'ч',
              'ш',
              'щ',
              'ъ',
              'ы',
              'ь',
              'э',
              'ю',
              'я');
          $cyrylicTo = array(
              'A',
              'B',
              'V',
              'G',
              'D',
              'Ie',
              'Io',
              'Z',
              'Z',
              'I',
              'J',
              'K',
              'L',
              'M',
              'N',
              'O',
              'P',
              'R',
              'S',
              'T',
              'U',
              'F',
              'Ch',
              'C',
              'Tch',
              'Sh',
              'Shtch',
              '',
              'Y',
              '',
              'E',
              'Iu',
              'Ia',
              'a',
              'b',
              'v',
              'g',
              'd',
              'ie',
              'io',
              'z',
              'z',
              'i',
              'j',
              'k',
              'l',
              'm',
              'n',
              'o',
              'p',
              'r',
              's',
              't',
              'u',
              'f',
              'ch',
              'c',
              'tch',
              'sh',
              'shtch',
              '',
              'y',
              '',
              'e',
              'iu',
              'ia');

          $from = array(
              "Á",
              "À",
              "Â",
              "Ä",
              "Ă",
              "Ā",
              "Ã",
              "Å",
              "Ą",
              "Æ",
              "Ć",
              "Ċ",
              "Ĉ",
              "Č",
              "Ç",
              "Ď",
              "Đ",
              "Ð",
              "É",
              "È",
              "Ė",
              "Ê",
              "Ë",
              "Ě",
              "Ē",
              "Ę",
              "Ə",
              "Ġ",
              "Ĝ",
              "Ğ",
              "Ģ",
              "á",
              "à",
              "â",
              "ä",
              "ă",
              "ā",
              "ã",
              "å",
              "ą",
              "æ",
              "ć",
              "ċ",
              "ĉ",
              "č",
              "ç",
              "ď",
              "đ",
              "ð",
              "é",
              "è",
              "ė",
              "ê",
              "ë",
              "ě",
              "ē",
              "ę",
              "ə",
              "ġ",
              "ĝ",
              "ğ",
              "ģ",
              "Ĥ",
              "Ħ",
              "I",
              "Í",
              "Ì",
              "İ",
              "Î",
              "Ï",
              "Ī",
              "Į",
              "Ĳ",
              "Ĵ",
              "Ķ",
              "Ļ",
              "Ł",
              "Ń",
              "Ň",
              "Ñ",
              "Ņ",
              "Ó",
              "Ò",
              "Ô",
              "Ö",
              "Õ",
              "Ő",
              "Ø",
              "Ơ",
              "Œ",
              "ĥ",
              "ħ",
              "ı",
              "í",
              "ì",
              "i",
              "î",
              "ï",
              "ī",
              "į",
              "ĳ",
              "ĵ",
              "ķ",
              "ļ",
              "ł",
              "ń",
              "ň",
              "ñ",
              "ņ",
              "ó",
              "ò",
              "ô",
              "ö",
              "õ",
              "ő",
              "ø",
              "ơ",
              "œ",
              "Ŕ",
              "Ř",
              "Ś",
              "Ŝ",
              "Š",
              "Ş",
              "Ť",
              "Ţ",
              "Þ",
              "Ú",
              "Ù",
              "Û",
              "Ü",
              "Ŭ",
              "Ū",
              "Ů",
              "Ų",
              "Ű",
              "Ư",
              "Ŵ",
              "Ý",
              "Ŷ",
              "Ÿ",
              "Ź",
              "Ż",
              "Ž",
              "ŕ",
              "ř",
              "ś",
              "ŝ",
              "š",
              "ş",
              "ß",
              "ť",
              "ţ",
              "þ",
              "ú",
              "ù",
              "û",
              "ü",
              "ŭ",
              "ū",
              "ů",
              "ų",
              "ű",
              "ư",
              "ŵ",
              "ý",
              "ŷ",
              "ÿ",
              "ź",
              "ż",
              "ž");
          $to = array(
              "A",
              "A",
              "A",
              "A",
              "A",
              "A",
              "A",
              "A",
              "A",
              "AE",
              "C",
              "C",
              "C",
              "C",
              "C",
              "D",
              "D",
              "D",
              "E",
              "E",
              "E",
              "E",
              "E",
              "E",
              "E",
              "E",
              "G",
              "G",
              "G",
              "G",
              "G",
              "a",
              "a",
              "a",
              "a",
              "a",
              "a",
              "a",
              "a",
              "a",
              "ae",
              "c",
              "c",
              "c",
              "c",
              "c",
              "d",
              "d",
              "d",
              "e",
              "e",
              "e",
              "e",
              "e",
              "e",
              "e",
              "e",
              "g",
              "g",
              "g",
              "g",
              "g",
              "H",
              "H",
              "I",
              "I",
              "I",
              "I",
              "I",
              "I",
              "I",
              "I",
              "IJ",
              "J",
              "K",
              "L",
              "L",
              "N",
              "N",
              "N",
              "N",
              "O",
              "O",
              "O",
              "O",
              "O",
              "O",
              "O",
              "O",
              "CE",
              "h",
              "h",
              "i",
              "i",
              "i",
              "i",
              "i",
              "i",
              "i",
              "i",
              "ij",
              "j",
              "k",
              "l",
              "l",
              "n",
              "n",
              "n",
              "n",
              "o",
              "o",
              "o",
              "o",
              "o",
              "o",
              "o",
              "o",
              "o",
              "R",
              "R",
              "S",
              "S",
              "S",
              "S",
              "T",
              "T",
              "T",
              "U",
              "U",
              "U",
              "U",
              "U",
              "U",
              "U",
              "U",
              "U",
              "U",
              "W",
              "Y",
              "Y",
              "Y",
              "Z",
              "Z",
              "Z",
              "r",
              "r",
              "s",
              "s",
              "s",
              "s",
              "B",
              "t",
              "t",
              "b",
              "u",
              "u",
              "u",
              "u",
              "u",
              "u",
              "u",
              "u",
              "u",
              "u",
              "w",
              "y",
              "y",
              "y",
              "z",
              "z",
              "z");
          $from = array_merge($from, $cyrylicFrom);
          $to = array_merge($to, $cyrylicTo);

          $newstring = str_replace($from, $to, $string);
          return $newstring;
      }
	  
      /**
       * Url::isActive()
       * 
       * @return
       */
      public static function isActive($val1, $val2, $class = "active")
      {
          if (isset($_GET[$val1]) and $_GET[$val1] == $val2) {
              return $class;
          }
      }
  }