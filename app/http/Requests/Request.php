<?php

namespace App\Http\Requests;

use Src\Sessions\Session;


class Request{
    
    private array $fields=[];
    private array $routeParam=[
        "routeParamName" => "",
        "routeParamValue" => ""
    ];

    public function setRequestFields(array $method):void
    {
        foreach($method as $key => $value)
        {
            $this->fields[$key]=$value;
        }
    }

    public function setRouteParam(string $routeParamName, string $routeParamValue):void 
    {
        $this->$routeParam["routeParamName"]=$routeParamName;
        $this->routeParam["routeParamValue"]=$routeParamValue;
    }

    public function get($key):mixed
    {
        return $this->fields[$key];
    }

    public function getAll():array 
    {
        return $this->fields;
    }

    public function validate(array $inputs):void
    {
        try 
        {
            if(count(array_diff_key($inputs,$this->fields) ) > 0)
                throw new \Exception("Validated input's doesn't exist in input field");

            $errors=[];
            foreach($inputs as $field_key => $value)
            {
                //iz oblika "required|numeric" u niz prebacuje
                $rules=explode("|",$value);
                foreach($rules as $rule)
                {
                    $validation=$this->validateSingleField($field_key,$rule);
                    if($validation["error"] == "true")
                    {
                        $message=$validation["message"];
                        array_push($errors,$message);
                        Session::set("errors",$errors,"singleUse");
                    }
                }
            }
        } 
        catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    private function validateSingleField($field_key, $validation_rule)
    {
        if(str_contains($validation_rule,":"))
        {
            $validation=explode(":",$validation_rule);
            $validation_rule=$validation[0];
            $param=$validation[1];
            return $this->$validation_rule($field_key,$param);
        }
        return $this->$validation_rule($field_key);
    }

    private function required($field_key):array
    {
        if(trim($this->fields[$field_key]) == "")
        {
            return array(
                "error" => "true", 
                "message" => $field_key . " must be filled"
            );
        }
        return array("error" => "false");
    }

    private function numeric($field_key):array
    {
        if(!is_numeric($this->fields[$field_key]))
        {
            return array(
                "error" => "true", 
                "message" => $field_key . " must be numeric"
            ); 
        }
        return array("error" => "false");
    }

    private function alpha($field_key):array
    {
        if(!ctype_alpha($this->fields[$field_key]))
        {
            return array(
                "error" => "true",
                "message" => $field_key . " must be letters only"
            );
        }
        return array("error" => "false");
    }

    private function min($field_key,$min_value):array
    {
        if((int)$this->fields[$field_key] < $min_value)
        {
            return array(
                "error" => "true", 
                "message" => $field_key . " must be greater or equal than " . $min_value
            );
        }
        return array("error" => "false");
    }

    private function max($field_key,$max_value):array
    {
        if((int)$this->fields[$field_key] > $max_value)
        {
            return array(
                "error" => "true",
                "messsage" => $field_key . " must be lower or equal than " . $max_value
            );
        }
        return array("error" => "false");
    }
}