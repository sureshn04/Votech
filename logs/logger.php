<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Handler\StreamHandler;

class Logger
{

  private const DEBUG_LOG_FILE = __DIR__ . '/debug.log';
  private const ERROR_LOG_FILE = __DIR__ . '/error.log';
  private const INFO_LOG_FILE = __DIR__ . '/info.log';

  private static $logger = null;
  private $monlogger;

  private function __construct()
  {
    try {
      $this->monoLogger = new \Monolog\Logger("OracularApp Logger");
      
      $this->monoLogger->pushHandler(new StreamHandler(self::DEBUG_LOG_FILE, \Monolog\Logger::DEBUG));

      $this->monoLogger->pushHandler(new StreamHandler(self::INFO_LOG_FILE, \Monolog\Logger::INFO));

      $this->monoLogger->pushHandler(new StreamHandler(self::ERROR_LOG_FILE, \Monolog\Logger::ERROR));
     
    } catch (Exception $e) {
      error_log("Error in setting up Monolog: " . $e->getMessage());
      die(1);
    }
  }
  public static function getLogger(): Logger
  {
    if (self::$logger == null) {
      self::$logger = new Logger();
    }
    return self::$logger;
  }
  public function pushToInfo(string $msg)
  {
    $this->monoLogger->info($msg);
  }
  public function pushToDebug(string $msg)
  {
    $this->monoLogger->debug($msg);
  }
  public function pushToError(string $msg)
  {
    $this->monoLogger->error($msg);
  }
}
