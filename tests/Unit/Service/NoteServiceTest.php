<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 10:35
 */

namespace Tests\Unit\Service;

use App\Exceptions\NoteExistedException;
use App\Http\Service\NoteService;
use App\Model\Note;
use Tests\TestCase;

class NoteServiceTest extends TestCase{

    private $noteService;

    public function testGetOneNote(){
        $this->noteService = new NoteService();
        $note = $this->noteService->getOneNote('gong','notebook1','My note1');
        $this->assertEquals('test test3', $note->getTagID());
        $this->assertEquals('1 2 3 4 5 6dd', $note->getNote());
        $this->assertEquals('just good', $note->getComment());
        $this->assertEquals('2017-11-14 20::16::33', $note->getCreatetime());
    }

    public function testGetOneNotebook(){
        $this->noteService = new NoteService();
        $array = $this->noteService->getOneNotebook('notebook1', 'byron');
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

    public function testGetNoteID(){
        $this->noteService = new NoteService();
        $array = $this->noteService->getNoteID('notebook1','byron');
        $this->assertEquals('My note', $array[0]['noteID']);
        $this->assertEquals('My note3', $array[1]['noteID']);
    }

    public function testAddNote(){
        $this->noteService = new NoteService();
        $note = new Note();
        $note->setNoteID('My note3');
        $note->setNotebookID('notebook1');
        $note->setUserID('gao');
        $note->setTagID('test test5');
        $note->setNote('1 2 3 4 5 6dd gg');
        $note->setComment('just good');
        $time = date('Y-m-d H::i::s');
        $note->setCreatetime($time);

        $this->noteService->addNote($note);

        $note1 = new Note();
        $note1->setNoteID('My note1');
        $note1->setNotebookID('notebook1');
        $note1->setUserID('gao');
        $note1->setTagID('test test5');
        $note1->setNote('1 2 3 4 5 6dd gg');
        $note1->setComment('just good');
        $time1 = date('Y-m-d H::i::s');
        $note1->setCreatetime($time1);
        try {
            $this->noteService->addNote($note1);
        } catch (NoteExistedException $e) {
            echo $e->getMessage();
        }
    }

    public function testModifyNote(){
        $this->noteService = new NoteService();
        $note = new Note();
        $note->setNoteID('My note');
        $note->setNotebookID('notebook1');
        $note->setUserID('byron');
        $note->setTagID('test test2 test3');
        $note->setNote('1 2 3 4 5 6dd yy ff');
        $note->setComment('just good');
        $time = date('Y-m-d H::i::s');
        $note->setCreatetime($time);

        $this->noteService->modifyNote($note,'My note' );

        $note1 = new Note();
        $note1->setNoteID('My note3');
        $note1->setNotebookID('notebook1');
        $note1->setUserID('byron');
        $note1->setTagID('test test2 test3');
        $note1->setNote('1 2 3 4 5 6dd yy ff');
        $note1->setComment('just good');
        $time1 = date('Y-m-d H::i::s');
        $note1->setCreatetime($time1);

        $this->noteService->modifyNote($note1,'My note2' );
    }

    public function testRemoveNote(){
        $this->noteService = new NoteService();
        $this->noteService->removeNote('gao','notebook1', 'My note3');
    }

    public function testRemoveNotes(){
        $this->noteService = new NoteService();
        $ids = array();
        array_push($ids, ['userID' => 'gao', 'notebookID' => 'notebook1', 'noteID' => 'My note1']);
        array_push($ids, ['userID' => 'gao', 'notebookID' => 'notebook1', 'noteID' => 'My note3']);
        $this->noteService->removeNotes($ids);
    }

    public function testRemoveOneNotebook(){
        $this->noteService = new NoteService();
        $this->noteService->removeOneNotebook('notebook1','gao');
    }

    public function testSearchNote(){
        $this->noteService = new NoteService();
        $array = $this->noteService->searchNote('3','notebook1','byron');
        var_dump($array);
    }
}
