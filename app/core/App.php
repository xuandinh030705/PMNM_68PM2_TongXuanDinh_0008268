<?php
class App
{
  protected $controller = "home";
  protected $action = "index";
  protected $param = [];

  public function __construct()
  {
    $urlProcessed = $this->urlProcess();
    //var_dump($urlProcessed);
    if (isset($urlProcessed[0])) {
      if (file_exists('../app/controllers/' . $urlProcessed[0] . '.php')) {
        $this->controller = $urlProcessed[0];
        unset($urlProcessed[0]);
      }
    }

    require_once '../app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;
    if (isset($urlProcessed[1])) {
      if (method_exists($this->controller, $urlProcessed[1])) {
        $this->action = $urlProcessed[1];
        unset($urlProcessed[1]);
      }
    }

    $this->param = $urlProcessed ? array_values($urlProcessed) : [];
    call_user_func_array([$this->controller, $this->action], $this->param);
  }

  public function urlProcess()
  {
    if (isset($_GET['url'])) {
      return explode('/', filter_var(trim($_GET['url'], '/')));
    }
  }
}