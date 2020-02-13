<?php
/**
 * ETF
 * Copyright 2020 ObsidianPHP, All Rights Reserved
 *
 * Website: https://github.com/ObsidianPHP/ETF
 * License: https://github.com/ObsidianPHP/ETF/blob/master/LICENSE
 * @noinspection PhpUnhandledExceptionInspection
*/

namespace Obsidian\ETF\Tests;

use Obsidian\ETF\Atom;
use Obsidian\ETF\ETF;
use Obsidian\ETF\Export;
use PHPUnit\Framework\TestCase;

final class ExportTest extends TestCase {
    /** @var ETF */
    protected $etf;
    
    function __construct($name = null, array $data = [], $dataName = '') {
        $this->etf = new ETF();
        
        parent::__construct($name, $data, $dataName);
    }
    
    function testExport(): void {
        // with mod <- Process, do: &mod.send/2
        $test = \base64_decode("g3F3DkVsaXhpci5Qcm9jZXNzdwRzZW5kYQI=");
        $expected = new Export((new Atom('Elixir.Process')), (new Atom('send')), 2);
        
        $decoded = $this->etf->decode($test);
        $encoded = $this->etf->encode($expected);
        
        $this->assertEquals($expected, $decoded);
        $this->assertSame($test, $encoded);
    }
    
    function testToArray(): void {
        $c1 = new Export((new Atom('Elixir.Process')), (new Atom('send')), 2);
        $c2 = array('module' => array('atom' => 'Elixir.Process'), 'function' => array('atom' => 'send'), 'arity' => 2);
        
        $this->assertSame($c2, $c1->toArray());
        $this->assertEquals($c1, Export::fromArray($c2));
    }
}
