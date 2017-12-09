<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 22:12
 */

namespace Tests\Unit\Dao;

use App\Http\Dao\NotebookDao;
use App\Model\Notebook;
use Tests\TestCase;

class NotebookDaoTest extends TestCase{

    private $notebookDao;

    public function testAdd(){
        $this->notebookDao = new NotebookDao();

        $notebook1 = new Notebook();
        $notebook1->setNotebookID('notebook1');
        $notebook1->setUserID('byron');
        $notebook1->setComment('just good');
        $time1 = date('Y-m-d H::i::s');
        $notebook1->setCreatetime($time1);

        $notebook2 = new Notebook();
        $notebook2->setNotebookID('notebook2');
        $notebook2->setUserID('byron');
        $notebook2->setComment('just good');
        $time2 = date('Y-m-d H::i::s');
        $notebook2->setCreatetime($time2);

        $notebook3 = new Notebook();
        $notebook3->setNotebookID('notebook1');
        $notebook3->setUserID('harvey');
        $notebook3->setComment('just good');
        $time3 = date('Y-m-d H::i::s');
        $notebook3->setCreatetime($time3);

        $notebook4 = new Notebook();
        $notebook4->setNotebookID('notebook1');
        $notebook4->setUserID('chris');
        $notebook4->setComment('just good');
        $time4 = date('Y-m-d H::i::s');
        $notebook4->setCreatetime($time4);

        $notebook5 = new Notebook();
        $notebook5->setNotebookID('notebook2');
        $notebook5->setUserID('chris');
        $notebook5->setComment('just good');
        $time5 = date('Y-m-d H::i::s');
        $notebook5->setCreatetime($time5);

        $this->notebookDao->addNotebook($notebook1);
        $this->notebookDao->addNotebook($notebook2);
        $this->notebookDao->addNotebook($notebook3);
        $this->notebookDao->addNotebook($notebook4);
        $this->notebookDao->addNotebook($notebook5);

    }

    public function testModify(){
        $this->notebookDao = new NotebookDao();

        $notebook1 = new Notebook();
        $notebook1->setNotebookID('notebook1');
        $notebook1->setUserID('byron');
        $notebook1->setComment('very good');
        $time1 = date('Y-m-d H::i::s');
        $notebook1->setCreatetime($time1);
        $this->notebookDao->modifyNotebook($notebook1);
    }

    public function testRemove(){
        $this->notebookDao = new NotebookDao();
        $this->notebookDao->removeNotebook('notebook2','chris');
    }

    public function testGetNotebook(){
        $this->notebookDao = new NotebookDao();
        $notebook = $this->notebookDao->getNotebook('notebook1','byron');
        $this->assertEquals('very good', $notebook->getComment());
        $this->assertEquals('2017-11-14 14::22::12', $notebook->getCreatetime());
    }

    public function testGetUserNotebookID(){
        $this->notebookDao = new NotebookDao();
        $id_array = $this->notebookDao->getUserNotebookID('byron');
        $this->assertEquals('notebook1', get_object_vars($id_array[0])['notebookID']);
        $this->assertEquals('notebook2', get_object_vars($id_array[1])['notebookID']);
    }

    public function testGetUserNotebook(){
        $this->notebookDao = new NotebookDao();
        $array = $this->notebookDao->getUserNotebook('byron');
        $this->assertEquals('notebook1', $array[0]['notebookID']);
        $this->assertEquals('byron', $array[0]['userID']);
        $this->assertEquals('very good', $array[0]['comment']);
        $this->assertEquals('2017-11-14 14::22::12', $array[0]['createtime']);

        $this->assertEquals('notebook2', $array[1]['notebookID']);
        $this->assertEquals('byron', $array[1]['userID']);
        $this->assertEquals('just good', $array[1]['comment']);
        $this->assertEquals('2017-11-14 11::49::07', $array[1]['createtime']);

    }

    public function testSearch(){
        $this->notebookDao = new NotebookDao();
        $array1 = $this->notebookDao->searchNotebook('note','byron');
        $array2 = $this->notebookDao->searchNotebook('2017-11','byron');
        $this->assertEquals('notebook1', $array1[0]['notebookID']);
        $this->assertEquals('byron', $array1[0]['userID']);
        $this->assertEquals('very good', $array1[0]['comment']);
        $this->assertEquals('2017-11-14 14::22::12', $array1[0]['createtime']);

        $this->assertEquals('notebook2', $array2[1]['notebookID']);
        $this->assertEquals('byron', $array2[1]['userID']);
        $this->assertEquals('just good', $array2[1]['comment']);
        $this->assertEquals('2017-11-14 11::49::07', $array2[1]['createtime']);
    }
}
