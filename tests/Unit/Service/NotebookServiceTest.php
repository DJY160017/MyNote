<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 10:36
 */

namespace Tests\Unit\Service;

use App\Exceptions\NotebookExistedException;
use App\Http\Service\NotebookService;
use App\Model\Notebook;
use Tests\TestCase;

class NotebookServiceTest extends TestCase{

    private $notebookService;

    public function testGetNotebook(){
        $this->notebookService = new NotebookService();
        $notebook = $this->notebookService->getNotebook('notebook1','byron');
        $this->assertEquals('very good', $notebook->getComment());
        $this->assertEquals('2017-11-14 14::22::12', $notebook->getCreatetime());
    }

    public function testGetUserNotebookID(){
        $this->notebookService = new NotebookService();
        $id_array = $this->notebookService->getUserNotebookID('byron');
        $this->assertEquals('notebook1', get_object_vars($id_array[0])['notebookID']);
        $this->assertEquals('notebook2', get_object_vars($id_array[1])['notebookID']);
    }

    public function testGetUserNotebook(){
        $this->notebookService = new NotebookService();
        $array = $this->notebookService->getUserNotebook('byron');
        $this->assertEquals('notebook1', $array[0]['notebookID']);
        $this->assertEquals('byron', $array[0]['userID']);
        $this->assertEquals('very good', $array[0]['comment']);
        $this->assertEquals('2017-11-14 14::22::12', $array[0]['createtime']);
    }

    public function testModifyNotebook(){
        $this->notebookService = new NotebookService();

        $notebook1 = new Notebook();
        $notebook1->setNotebookID('notebook1');
        $notebook1->setUserID('gao');
        $notebook1->setComment('very good gg gg');
        $time1 = date('Y-m-d H::i::s');
        $notebook1->setCreatetime($time1);
        $this->notebookService->modifyNotebook($notebook1, 'notebook1');

        $notebook2 = new Notebook();
        $notebook2->setNotebookID('notebook3');
        $notebook2->setUserID('gao');
        $notebook2->setComment('very good gg gg');
        $time2 = date('Y-m-d H::i::s');
        $notebook2->setCreatetime($time2);
        $this->notebookService->modifyNotebook($notebook2, 'notebook2');
    }

    public function testAddNotebook(){
        $this->notebookService = new NotebookService();

//        $notebook1 = new Notebook();
//        $notebook1->setNotebookID('notebook1');
//        $notebook1->setUserID('gao');
//        $notebook1->setComment('just good');
//        $time1 = date('Y-m-d H::i::s');
//        $notebook1->setCreatetime($time1);

        $notebook2 = new Notebook();
        $notebook2->setNotebookID('dong');
        $notebook2->setUserID('byron');
        $notebook2->setComment('just good');
        $time2 = date('Y-m-d H::i::s');
        $notebook2->setCreatetime($time2);

//        $this->notebookService->addNotebook($notebook1);
        try {
            $this->notebookService->addNotebook($notebook2);
        } catch (NotebookExistedException $e) {
            echo 'hhhhhhh';
        }
    }

    public function testRemoveNotebook(){
        $this->notebookService = new NotebookService();
        $this->notebookService->removeNotebook('notebook1','gao');
    }

    public function testSearch(){
        $this->notebookService = new NotebookService();
        $array = $this->notebookService->searchNotebook('note','byron');
        var_dump($array);
    }
}
