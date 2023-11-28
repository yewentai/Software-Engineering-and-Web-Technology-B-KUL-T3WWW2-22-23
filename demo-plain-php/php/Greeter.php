<?php

/**
 * This class will greet you on the main page
 * @author Jeroen
 */
class Greeter
{
    public function __construct() {
    }

    /**
     * Returns a random greeting
     * @return string a random greeting
     */
    public function getGreeting() : string {
        $greeting = ['cool', 'awesome', 'sublime'];
        $index = rand(0,2);
        return "Welcome to this $greeting[$index] website";
    }
}