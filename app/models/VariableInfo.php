<?php 

class VariableInfo {
   public $variableName;

   public function __construct($myArray1)
   {
        $this->arrayVar = $myArray1;
        $this->variableName = 'um';
   }
   
   public function setVarAttributes () {
       $this->variableName = 'Updated';
   }
   
   public function getVarAttributes () {
       foreach ($this->arrayVar as $key=>$value) {
            $this->$key = $value;
       }
   }
}
?>