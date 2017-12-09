<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/9
 * Time: 0:18
 */

namespace App\Http\Util;

use Tests\TestCase;

;

class MatcherTest extends TestCase{

    public function test(){
        $matcher = new Matcher();
        $this->assertEquals(true, $matcher->mailMatcher('runoob@runoob.com'));
        $this->assertEquals(false, $matcher->mailMatcher('rcbdvbfhvfb.com'));
    }

}
