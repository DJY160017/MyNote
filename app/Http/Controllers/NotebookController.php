<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/4
 * Time: 13:19
 */

namespace App\Http\Controllers;


use App\Exceptions\NotebookExistedException;
use App\Http\Service\NotebookService;
use App\Http\Service\NoteService;
use App\Http\Util\IDReserver;
use App\Model\Notebook;
use Illuminate\Http\Request;

class NotebookController extends Controller {

    private $notebookService;

    private $noteService;

    public function showNotebook(){
        return view('notebook.notebook');
    }

    public function createNotebook(){
        return view('notebook.createNotebook');
    }

    public function create(Request $request){
        $notebook_new = $request->input('notebook_new');
        $this->notebookService = new NotebookService();
        $id_resever = new IDReserver();
        try {
            $notebook = new Notebook();
            $notebook->setNotebookID($notebook_new);
            $notebook->setUserID($id_resever->getUserID());
            $notebook->setComment('');
            $time = date('Y-m-d H::i::s');
            $notebook->setCreatetime($time);
            $this->notebookService->addNotebook($notebook);
            return response()->json(array(
                'result'=>'success'
            ));
        } catch (NotebookExistedException $e) {
            return response()->json(array(
                'result'=>'该笔记本已存在'
            ));
        }
    }

    public function getAllNotebook(){
        $this->notebookService = new NotebookService();
        $this->noteService = new NoteService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notebooks = $this->notebookService->getUserNotebook($userID);
        $result_notebooks = array();
        for($i = 0;$i<count($notebooks);$i++){
            $array = array();
            array_push($array,  $notebooks[$i]['notebookID']);
            array_push($array,  $notebooks[$i]['createtime']);
            $num = $this->noteService->countNotebook($notebooks[$i]['notebookID'], $notebooks[$i]['userID']);
            array_push($array, $num);
            array_push($result_notebooks, $array);
        }
        return response()->json($result_notebooks);
    }

    public function search(Request $request){
        $this->notebookService = new NotebookService();
        $this->noteService = new NoteService();
        $info = $request->input('info');
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notebooks = $this->notebookService->searchNotebook($info, $userID);
        $result_notebooks = array();
        for($i = 0;$i<count($notebooks);$i++){
            $array = array();
            array_push($array,  $notebooks[$i]['notebookID']);
            array_push($array,  $notebooks[$i]['createtime']);
            $num = $this->noteService->countNotebook($notebooks[$i]['notebookID'], $notebooks[$i]['userID']);
            array_push($array, $num);
            array_push($result_notebooks, $array);
        }
        return response()->json($result_notebooks);
    }

    public function modifyNotebookID(Request $request){
        $this->notebookService =new NotebookService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $new_notebookID = $request->input('new_notebookID');
        $old_notebookID = $request->input('old_notebookID');
        $notebook = $this->notebookService->getNotebook($old_notebookID, $userID);
        $notebook->setNotebookID($new_notebookID);
        try {
            $this->notebookService->modifyNotebook($notebook, $old_notebookID);
        } catch (NotebookExistedException $e) {
            return ['result'=>'笔记本名重复'];
        }
        return ['result'=>'success'];
    }

    public function removeNotebook(Request $request){
        $this->notebookService =new NotebookService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notebookID = $request->input('notebookID');
        $this->notebookService->removeNotebook($notebookID, $userID);
        return ['result'=>'success'];
    }

}