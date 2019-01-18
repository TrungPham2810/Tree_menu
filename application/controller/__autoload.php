<?php 
spl_autoload_register(function($className) {
	include('../application/controller/class/'.$className.'.php');
});
 ?>