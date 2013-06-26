<?php
/**
 * Various Utilities for wordpress and other php projects
 *
 * Author: Angelo D'Ambrosio
 * Version: 1.2
 */

global $bk1_debug_state;
$bk1_debug_state = true;

function bk1_debug($var, $override){

   global $bk1_debug_state;

   $override = strtolower((string)$override);

   if (in_array($override, ['off', false, 0] )){
	  return;
   }
   elseif ( in_array($override, ['on', true, 1] ) ){

   }
   else {
	  if (in_array($bk1_debug_state, ['on', true, 1])){
		 return;
	  }
   }

   $result = var_export( $var, true );

   $trace = debug_backtrace();
   $level = 1;
   @$file   = $trace[$level]['file'];
   @$line   = $trace[$level]['line'];
   @$object = $trace[$level]['object'];
   if (is_object($object)) { $object = get_class($object); }

   error_log("Line $line ".($object?"of object $object":"")."(in $file):\n$result");
}

function bk1_set_debug_state($state){

   global $bk1_debug_state;

   $state = strtolower((string)$state);
   if (in_array($state, ['on', true, 1] )){
	  $bk1_debug_state = true;
   }
   elseif (in_array($state, ['off', false, 0] )){
	  $bk1_debug_state = false;
   }
   else {
	  trigger_error("Wrong argument for 'bk1_set_debug_state', expected ['on', true, 1] or ['off', false, 0]");
   }
}


?>
