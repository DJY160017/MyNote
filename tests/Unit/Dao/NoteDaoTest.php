<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/13
 * Time: 22:11
 */

namespace Tests\Unit\Dao;

use App\Http\Dao\NoteDao;
use App\Model\Note;
use Tests\TestCase;

class NoteDaoTest extends TestCase{

    private $noteDao;

    public function testGetOneNote(){
        $this->noteDao = new NoteDao();
        $note = $this->noteDao->getOneNote('gong','notebook1','My note1');
        $this->assertEquals('test test3', $note->getTagID());
        $this->assertEquals('1 2 3 4 5 6dd', $note->getNote());
        $this->assertEquals('just good', $note->getComment());
        $this->assertEquals('2017-11-14 20::16::33', $note->getCreatetime());
    }

    public function testGetOneNotebook(){
        $this->noteDao = new NoteDao();
        $array = $this->noteDao->getOneNotebook('notebook1', 'byron');
        $this->assertEquals('My note', $array[0]['noteID']);
        $this->assertEquals('test test1 test3', $array[0]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd yy ff', $array[0]['note']);
        $this->assertEquals('just good', $array[0]['comment']);
        $this->assertEquals('2017-11-14 20::09::00',$array[0]['createtime']);

        $this->assertEquals('My note2', $array[1]['noteID']);
        $this->assertEquals('test test2', $array[1]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd', $array[1]['note']);
        $this->assertEquals('just good', $array[1]['comment']);
        $this->assertEquals('2017-11-14 15::15::51',$array[1]['createtime']);

    }

    public function testGetNoteByTag(){
        $this->noteDao = new NoteDao();
        $array = $this->noteDao->getNoteByTag('byron', ['test']);
        $this->assertEquals('My note', $array[0]['noteID']);
        $this->assertEquals('test test1 test3', $array[0]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd yy ff', $array[0]['note']);
        $this->assertEquals('just good', $array[0]['comment']);
        $this->assertEquals('2017-11-14 20::09::00',$array[0]['createtime']);

        $this->assertEquals('My note2', $array[1]['noteID']);
        $this->assertEquals('test test2', $array[1]['tagID']);
        $this->assertEquals('1 2 3 4 5 6dd', $array[1]['note']);
        $this->assertEquals('just good', $array[1]['comment']);
        $this->assertEquals('2017-11-14 15::15::51',$array[1]['createtime']);
    }

    public function testAddNote(){
        $this->noteDao = new NoteDao();
        $note = new Note();
        $note->setNoteID('My note1');
        $note->setNotebookID('notebook1');
        $note->setUserID('gong');
        $note->setTagID('test test3');
        $note->setNote('1 2 3 4 5 6dd');
        $note->setComment('just good');
        $time = date('Y-m-d H::i::s');
        $note->setCreatetime($time);

        $this->noteDao->addNote($note);

        $note1 = new Note();
        $note1->setNoteID('My note2');
        $note1->setNotebookID('notebook1');
        $note1->setUserID('gong');
        $note1->setTagID('test4 test2');
        $note1->setNote('1 2 3 4 5 6dd');
        $note1->setComment('just good');
        $time1 = date('Y-m-d H::i::s');
        $note1->setCreatetime($time1);

        $this->noteDao->addNote($note1);
    }

    public function testModifyNote(){
        $this->noteDao = new NoteDao();
        $note = new Note();
        $note->setNoteID('My note');
        $note->setNotebookID('notebook1');
        $note->setUserID('byron');
        $note->setTagID('test test1 test3');
        $note->setNote('1 2 3 4 5 6dd yy ff');
        $note->setComment('just good');
        $time = date('Y-m-d H::i::s');
        $note->setCreatetime($time);

        $this->noteDao->modifyNote($note);
    }

    public function testRemoveNote(){
        $this->noteDao = new NoteDao();
        $this->noteDao->removeNote('gao','notebook1', 'My note1');
    }

    public function testRemoveNotes(){
        $this->noteDao = new NoteDao();
        $ids = array();
        array_push($ids, ['userID' => 'harvey', 'notebookID' => 'notebook2', 'noteID' => 'My note2']);
        array_push($ids, ['userID' => 'gong', 'notebookID' => 'notebook1', 'noteID' => 'My note2']);
        $this->noteDao->removeNotes($ids);
    }

    public function testRemoveOneNotebook(){
        $this->noteDao = new NoteDao();
        $this->noteDao->removeOneNotebook('notebook2','harvey');
    }

    public function testCountNotebook(){
        $this->noteDao = new NoteDao();
        $this->assertEquals(2, $this->noteDao->countNotebook('notebook1','byron'));
    }
}
