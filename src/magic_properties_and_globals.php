<?php

/**
 * @property string $stringVar
 * @property-read string $readVar
 * @property string[][] $mapVar
 * @property DateTime $dateVar
 * @property mixed $mixedVar a magic property that explicitly has a mixed type
 * @property $undeclaredTypeVar a magic property that has a property annotation without a type (automatically inferred)
 */
class RunkitGlobal {
    /** @param string */
    private $_stringVar;
    /** @param string[][] */
    private $_mapVar;
    /** @param DateTime */
    private $_dateVar;
    /** @param mixed */
    private $_mixedVar;
    private $_undeclaredTypeVar;

    public function __construct() {
        $this->_stringVar = 'value';
        $this->_mapVar = ['a' => ['b' => 'value']];
        $this->_dateVar = new DateTime();
        $this->_mixedVar = null;
        $this->_undeclaredTypeVar = null;
    }

    // A boilerplate getter that implements the declared property annotation.
    // Note: The getters aren't analyzed by phan to check if they match.
    public function __get($name) {
        switch($name) {
        case 'stringVar':
            return $this->_stringVar;
        case 'readVar':
            return 'astring';
        case 'mapVar':
            return $this->_mapVar;
        case 'dateVar':
            return $this->_dateVar;
        case 'mixedVar':
            return $this->_mixedVar;
        case 'undeclaredTypeVar':
            return $this->_undeclaredTypeVar;
        default:
            return null;
        }
    }

    // A boilerplate setter that implements the declared property annotation.
    // The setters aren't yet analyzed by phan to check if they match.
    public function __set($name, $value) {
        switch($name) {
        case 'stringVar':
            $this->_stringVar = $value;
            return;
        case 'mapVar':
            $this->_mapVar = $value;
            return;
        case 'dateVar':
            $this->_dateVar = $value;
            return;
        case 'mixedVar':
            $this->_mixedVar = $value;
            return;
        case 'undeclaredTypeVar':
            $this->_undeclaredTypeVar = $value;
        default:
            return;
        }
    }
}

function testMagic() {
    $_RK->stringVar = 'a';
    echo strlen($_RK->stringVar) . "\n";
    $_RK->stringVar = new stdClass();  // incorrect type
    echo intdiv($_RK->readVar, 2);  // incorrect type.
    echo strlen($_RK->mapVar['a']);  // incorrect type
    echo strlen($_RK->mapVar['a']['b']);  // incorrect type
    $_RK->mapVar = ['a' => ['b' => 'xyz']];  // correct type
    $_RK->mapVar = ['a' => []];  // compatible type
    $_RK->mapVar = ['a' => 'c'];  // incompatible type
    $_RK->dateVar = 42;  // Bug
    $_RK->dateVar = new DateTime();
    echo intdiv($_RK->stringVar, 4) . "\n";  // incorrect type for intdiv
    $_RK->mixedVar = 'a';
    $_RK->mixedVar = new stdClass();
    $_RK->undeclaredTypeVar = 'a';
    $_RK->undeclaredTypeVar = new stdClass();
}

function badAssignmentToSuperglobalPre() {
    $_RK = 'bad';
    $_GLOBALS['_RK'] = [123];
}

function goodAssignmentToSuperglobal() {
    $_RK = new RunkitGlobal();
}

function badAssignmentToSuperglobal() {
    $_RK = 'bad';
    $_GLOBALS['_RK'] = [123];
}

testMagic();
