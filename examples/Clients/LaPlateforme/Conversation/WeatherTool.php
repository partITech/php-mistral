<?php

use \Partitech\PhpMistral\Tools\FunctionTool;
use \Partitech\PhpMistral\Tools\Tool;
use \Partitech\PhpMistral\Tools\Parameter;
class WeatherTool extends Tool
{
    public function __construct(){
        $this->type = 'function';

        $this->function = new FunctionTool(
            name: 'get_weather',
            description: 'Get the weather in a city',
            parameters: [
                new Parameter(
                    type: Parameter::STRING_TYPE,
                    name: 'city',
                    description: 'The city to get the weather for',
                    required: true
                )
            ]
        );
    }
}