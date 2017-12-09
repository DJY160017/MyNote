<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/12/4
 * Time: 13:19
 */

namespace App\Http\Controllers;


use App\Exceptions\TagExistException;
use App\Http\Service\NoteService;
use App\Http\Service\TagService;
use App\Http\Util\IDReserver;
use Illuminate\Http\Request;

class TagController extends Controller {

    private $tagService;

    private $noteService;

    public function createTag(){
        return view('tag.createTag');
    }

    public function create(Request $request){
        $tag_new = $request->input('tag_new');
        $this->tagService = new TagService();
        $id_resever = new IDReserver();
        try {
            $this->tagService->add($id_resever->getUserID(), $tag_new);
            return ['result'=>'success'];
        } catch (TagExistException $e) {
            return ['result'=>'该标签已存在'];
        }
    }

    public function showSearchResult(Request $request){
        $info = $request->input('info');
        return view('tag.tagSearchList')->with('info', $info);
    }

    public function search(Request $request){
        $info = $request->input('info');
        $this->noteService = new NoteService();
        $id_resever = new IDReserver();
        $userID = $id_resever->getUserID();
        $notes = $this->noteService->searchNoteByTag($info, $userID);
        $result_notes = array();
        for($i = 0;$i<count($notes);$i++){
            $array = array();
            array_push($array,  $notes[$i]['notebookID']);
            array_push($array,  $notes[$i]['noteID']);
            array_push($array,  $notes[$i]['tagID']);
            array_push($array,  $notes[$i]['createtime']);
            array_push($result_notes, $array);
        }
        return response()->json($result_notes);
    }
}