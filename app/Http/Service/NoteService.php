<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 8:14
 */

namespace App\Http\Service;


use App\Exceptions\NoteExistedException;
use App\Http\Dao\NoteDao;
use App\Model\Note;

class NoteService
{

    /**
     * @var NoteDao 笔记数据层实体
     */
    private $noteDao;

    /**
     * NoteService constructor.
     */
    public function __construct()
    {
        $this->noteDao = new NoteDao();
    }

    /**
     * 用于获取指定用户，指定笔记本，指定笔记ID的笔记
     *
     * @param $userID string 用户ID
     * @param $notebookID string 笔记本ID
     * @param $noteID string 笔记ID
     * @return Note 笔记实体
     *
     */
    public function getOneNote($userID, $notebookID, $noteID)
    {
        return $this->noteDao->getOneNote($userID, $notebookID, $noteID);
    }

    /**
     * 用于获取指定用户，指定笔记本ID的所有笔记
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return array 所有笔记
     *
     */
    public function getOneNotebook($notebookID, $userID)
    {
        return $this->noteDao->getOneNotebook($notebookID, $userID);
    }

    /**
     * 用于获取指定笔记本ID， 用户ID的所有笔记ID
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return array
     */
    public function getNoteID($notebookID, $userID)
    {
        return $this->noteDao->getNoteID($notebookID, $userID);
    }

    /**
     * 用户添加笔记
     *
     * @param $note Note
     * @return boolean 是否添加成功
     * @throws NoteExistedException
     */
    public function addNote($note){
        $note_temp = $this->getOneNote($note->getUserID(), $note->getNotebookID(), $note->getNoteID());

        if (!is_null($note_temp)) {
            throw new NoteExistedException();
        }

        return $this->noteDao->addNote($note);
    }

    /**
     * 用于修改指定note的内容
     *
     * @param $note Note
     * @param $preNoteID string
     * @param $preNotebookID string
     * @return boolean 是否成功修改
     */
    public function modifyNote($note, $preNoteID, $preNotebookID){
        if (strcmp($note->getNoteID(), $preNoteID) == 0 && strcmp($note->getNotebookID(), $preNotebookID) == 0) {
            return $this->modifyOneNote($note);
        } else {
            return $this->modifyOneNoteID($note, $preNoteID, $preNotebookID);
        }
    }

    /**
     * 用于删除笔记
     *
     * @param $userID string 用户ID
     * @param $notebookID string 笔记本ID
     * @param $noteID string 笔记ID
     * @return boolean 是否成功删除笔记
     *
     */
    public function removeNote($userID, $notebookID, $noteID)
    {
        return $this->noteDao->removeNote($userID, $notebookID, $noteID);
    }

    /**
     * 用于批量删除笔记
     *
     * @param $ids array 笔记ID集合
     * @return boolean 是否成功删除
     */
    public function removeNotes($ids)
    {
        return $this->noteDao->removeNotes($ids);
    }

    /**
     * 用于删除笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 笔记ID
     * @return boolean 是否成功删除笔记本
     */
    public function removeOneNotebook($notebookID, $userID)
    {
        return $this->noteDao->removeOneNotebook($notebookID, $userID);
    }

    /**
     * 修改note的内容
     *
     * @param $note Note
     * @return boolean  是否成功修改
     */
    private function modifyOneNote($note)
    {
        return $this->noteDao->modifyNote($note);
    }

    /**
     * 修改noteID
     *
     * @param $note Note
     * @param $preNoteID string
     * @param $preNotebookID string
     * @return boolean 是否成功修改
     * @throws NoteExistedException
     */
    private function modifyOneNoteID($note, $preNoteID, $preNotebookID)
    {
        $note_temp = $this->getOneNote($note->getUserID(), $note->getNotebookID(), $note->getNoteID());

        if (!is_null($note_temp)) {
            throw new NoteExistedException();
        }

        $this->removeNote($note->getUserID(), $preNotebookID, $preNoteID);
        $result = $this->addNote($note);
        return $result;
    }

    /**
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return int 笔记本笔记数量
     */
    public function countNotebook($notebookID, $userID){
        return $this->noteDao->countNotebook($notebookID, $userID);
    }

    /**
     * @param $userID string 用户ID
     * @return int 笔记本笔记数量
     */
    public function countNote($userID){
       return $this->noteDao->countNote($userID);
    }

    /**
     * @param $info string
     * @param $notebookID string
     * @param $userID string
     * @return array
     */
    public function searchNote($info, $notebookID, $userID){
        return $this->noteDao->searchNote($info, $notebookID, $userID);
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchNoteByTag($info, $userID){
        return $this->noteDao->searchNoteByTag($info, $userID);
    }
}