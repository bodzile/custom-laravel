<?php

namespace Src;

class Pipeline{

    private $data;
    private $pipes=[];

    public static function send($data):Pipeline
    {
        $pipeline=new self;
        $pipeline->data=$data;

        return $pipeline;
    }

    public function through(array|null $functions):Pipeline
    {
        $this->pipes=$functions;
        return $this;
    }

    public function to(\Closure $destination)
    {
        $next=$destination;
        $value=$this->data;

        if($this->pipes)
        {
            foreach(array_reverse($this->pipes) as $pipe)
            {
                //$resolved=$this->resolve($pipe);
                $next=function($value) use ($pipe,$next){
                    return call_user_func([$pipe,"handle"],$value,$next);
                };
            }
        }

        return $next($this->data);
    }

}