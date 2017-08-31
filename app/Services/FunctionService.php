<?php 

namespace App\Services;
use App\FunctionTypes;

class FunctionService
{
  public function __construct()
  {
    $this->functionModel = new FunctionTypes;
  }
    
  public function getAllActiveData(){
    return $this->functionModel->getAllActiveData();
  }
}

?>