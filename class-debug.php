<?php 
namespace chipbug\php_video_reformatter;

class Debug{

	public function __contruct(){

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', "./debug.log");
}