<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 22:12
 */

namespace Tests\Unit\Dao;

use App\Http\Dao\TagDao;
use Tests\TestCase;

class TagDaoTest extends TestCase{

    private $tagDao;

    public function testGet(){
        $this->tagDao = new TagDao();
        $array = $this->tagDao->getTags('byron');
        $this->assertEquals('test', $array[0]);
        $this->assertEquals('test1', $array[1]);
        $this->assertEquals('test2', $array[2]);
        $this->assertEquals('test3', $array[3]);

    }

    public function testRemove(){
        $this->tagDao = new TagDao();
        $this->tagDao->remove('gong','test3');
    }

    public function testAdd(){
        $this->tagDao = new TagDao();
        $this->tagDao->add('byron','test');
        $this->tagDao->add('byron','test1');
        $this->tagDao->add('byron','test2');
        $this->tagDao->add('byron','test3');

        $this->tagDao->add('harvey','test');
        $this->tagDao->add('harvey','test3');

        $this->tagDao->add('chris','test2');
        $this->tagDao->add('chris','test4');

        $this->tagDao->add('gong','test');
        $this->tagDao->add('gong','test3');
    }
}
