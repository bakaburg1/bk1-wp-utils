<?php
/**
 * Various Utilities for wordpress and other php projects
 *
 * Author: Angelo D'Ambrosio
 * Version: 1.3
 */

class bk1_debug{
   private static $state 		= true;
   private static $buffer 		= '';
   private static $last_time 	= null;
   private static $print_always = false;

   public static function state_set($state){

	  $state = strtolower((string)$state);
	  if ($state === 'on' OR $state === true){
		 self :: $state = true;
	  }
	  elseif ($state === 'off' OR $state === false){
		 self :: $state = false;
	  }
	  else {
		 trigger_error("Wrong argument for 'bk1_set_debug_state', expected 'on' or 'off'");
	  }
   }

   public static function print_always_set($state){

	  $state = strtolower((string)$state);
	  if ($state === 'on' OR $state === true){
		 self::$print_always = true;
	  }
	  elseif ($state === 'off' OR $state === false){
		 self::$print_always = false;
	  }
	  else {
		 trigger_error("Wrong argument for 'self::print_always_set()', expected 'on' or 'off'");
	  }

   }

   public static function log($var, $override = null){

	  if (isset($override)){
		 $override = strtolower($override);
		 if ( $override === 'off' OR $override == false ){
			return;
		 }
		 elseif ( $override === 'on' OR $override == true ){
		 }
	  }
	  else {
		 if (self::$state === false){
			return;
		 }
	  }

	  $result = var_export( $var, true );

	  $trace 	= debug_backtrace();
	  $level 	= 1;
	  @$file   	= $trace[$level]['file'];
	  @$line   	= $trace[$level]['line'];
	  @$object 	= $trace[$level]['object'];
	  if (is_object($object)) { $object = get_class($object); }

	  self::$buffer .= "\n---- time: ".date(DATE_RSS, time()) . (self::$last_time ? ' ---- duration: '.round((microtime(true) - self::$last_time), 5) : '') ."----\n";

	  self::$buffer .= "Line $line ".($object?"of object $object":"")."(in $file):\n$result\n";

	  self::$last_time = microtime(true);

	  if (self::$print_always){
		 self::log_print();
	  }
   }

   public static function log_print(){

	  if (self::$state){
		 error_log(self::$buffer);
	  }

	  self::$buffer = '';
	  self::$last_time = null;
   }
}

?>
