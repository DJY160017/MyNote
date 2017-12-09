<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 10:37
 */

namespace Tests\Unit\Service;

use App\Http\Service\TagService;
use Tests\TestCase;

class TagServiceTest extends TestCase{

    private $tagService;

    public function testSearch(){
        $this->tagService = new TagService();
        $array = $this->tagService->search('byron', ['test']);
        $this->assertEquals('My note', $array[0]['noteID']);
        $this->assertEquals('test test2 test3', $array[0]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd yy ff', $array[0]['note']);
        $this->assertEquals('just good', $array[0]['comment']);
        $this->assertEquals('2017-11-15 11::26::19',$array[0]['createtime']);

        $this->assertEquals('My note3', $array[1]['noteID']);
        $this->assertEquals('test test2 test3', $array[1]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd yy ff', $array[1]['note']);
        $this->assertEquals('just good', $array[1]['comment']);
        $this->assertEquals('2017-11-15 11::17::08',$array[1]['createtime']);
    }

    public function testGetTags(){
        $this->tagService = new TagService();
        $array = $this->tagService->getTags('byron');
        $this->assertEquals('test', $array[0]);
        $this->assertEquals('test1', $array[1]);
        $this->assertEquals('test2', $array[2]);
        $this->assertEquals('test3', $array[3]);
    }

    public function testAdd(){
        $this->tagService = new TagService();
        $this->tagService->add('gao','test3');
        $this->tagService->add('gao','test6');
    }

    public function testRemove(){
        $this->tagService = new TagService();
        $this->tagService->remove('gao','test3');
        $this->tagService->remove('gao','test6');
    }
}
