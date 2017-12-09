<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/4
 * Time: 13:19
 */

namespace App\Http\Controllers;


use App\Exceptions\NoteExistedException;
use App\Http\Service\NotebookService;
use App\Http\Service\NoteService;
use App\Http\Service\TagService;
use App\Http\Util\IDReserver;
use App\Model\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    private $noteService;

    private $tagService;

    private $notebookService;

    public function createNote(){
        return view('note.note');
    }

    public function showNotelist(Request $request){
        return view('note.notelist')->with('result', $request->input('notebookID'));
    }

    public function showNote(Request $request){
        $noteID = $request->input('noteID');
        $notebookID = $request->input('notebookID');
        return view('note.noteinfo',[
            'noteID'=>$noteID,
            'notebookID'=>$notebookID
            ]);
    }

    public function create(Request $request)
    {
        $notebook = $request->input('notebook');
        $tag = $request->input('tag');
        $title = $request->input('title');
        $note_content = $request->input('note');

        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $this->noteService = new NoteService();
        $note = new Note();
        $note->setNoteID($title);
        $note->setNotebookID($notebook);
        $note->setUserID($userID);
        $note->setTagID($tag);
        $note->setNote($note_content);
        $note->setComment('');
        $time = date('Y-m-d H::i::s');
        $note->setCreatetime($time);
        try {
            $this->noteService->addNote($note);
            return response()->json(array(
                'result' => 'success'
            ));
        } catch (NoteExistedException $e) {
            return response()->json(array(
                'result' => '笔记ID重复'
            ));
        }
    }

    public function getInitNotebookInfo()
    {
        $id_resever = new IDReserver();
        $this->notebookService = new NotebookService();
        $userID = $id_resever->getUserID();
        $books = $this->notebookService->getUserNotebookID($userID);
        $result = array();
        foreach ($books as $book) {
            array_push($result, get_object_vars($book)['notebookID']);
        }
        return response()->json($result);
    }

    public function getInitTagInfo(){
        $id_resever = new IDReserver();
        $this->tagService = new TagService();
        $userID = $id_resever->getUserID();
        $tags = $this->tagService->getTags($userID);
        return response()->json($tags);
    }

    public function getAllNote(Request $request){
        $this->noteService = new NoteService();
        $notebookID = $request->input('notebookID');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notes = $this->noteService->getOneNotebook($notebookID, $userID);
        $result = array();
        for ($i = 0; $i < count($notes); $i++) {
            $array = array();
            array_push($array, $notes[$i]['noteID']);
            array_push($array, $notes[$i]['createtime']);
            array_push($result, $array);
        }
        return response()->json($result);
    }

    public function search(Request $request){
        $this->noteService = new NoteService();
        $info = $request->input('info');
        $notebookID = $request->input('notebookID');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notes = $this->noteService->searchNote($info, $notebookID, $userID);
        $result_notes = array();
        for($i = 0;$i<count($notes);$i++){
            $array = array();
            array_push($array,  $notes[$i]['noteID']);
            array_push($array,  $notes[$i]['createtime']);
            array_push($result_notes, $array);
        }
        return response()->json($result_notes);
    }

    public function getOneNote(Request $request){
        $this->noteService = new NoteService();
        $noteID = $request->input('noteID');
        $notebookID = $request->input('notebookID');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $note = $this->noteService->getOneNote($userID,$notebookID,$noteID);
        return response()->json(array(
            'tagID'=>$note->getTagID(),
            'note'=>$note->getNote()
        ));
    }

    public function modifyNote(Request $request){
        $old_noteID = $request->input('old_noteID');
        $new_noteID = $request->input('new_noteID');
        $old_notebookID = $request->input('old_notebookID');
        $new_notebookID = $request->input('new_notebookID');
        $note = $request->input('note');
        $tagID = $request->input('tagID');
        $time = date('Y-m-d H::i::s');
        $this->noteService = new NoteService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $note_entity = $this->noteService->getOneNote($userID,$old_notebookID,$old_noteID);
        $note_entity->setNotebookID($new_notebookID);
        $note_entity->setNoteID($new_noteID);
        $note_entity->setNote($note);
        $note_entity->setTagID($tagID);
        $note_entity->setCreatetime($time);
        try {
            $this->noteService->modifyNote($note_entity, $old_noteID,$old_notebookID);
            return ['result'=>'success'];
        } catch (NoteExistedException $e) {
            return ['result'=>'笔记重复'];
        }
    }

    public function removeNote(Request $request){
        $noteID = $request->input('noteID');
        $notebookID = $request->input('notebookID');
        $this->noteService = new NoteService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $this->noteService->removeNote($userID,$notebookID,$noteID);
        return ['result'=>'success'];
    }
}