<?php
/**
 * Created by PhpStorm.
 * User: Byron Dong
 * Date: 2017/11/15
 * Time: 9:18
 */

namespace App\Http\Service;


use App\Exceptions\NotebookExistedException;
use App\Http\Dao\NotebookDao;
use App\Model\Notebook;

class NotebookService{

    /**
     * @var NotebookDao
     */
    private $notebookDao;

    /**
     * @var NoteService
     */
    private $noteService;

    /**
     * NotebookService constructor.
     */
    public function __construct(){
        $this->notebookDao = new NotebookDao();
        $this->noteService = new NoteService();
    }

    /**
     * 用于获取指定用户，指定笔记本ID的笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return Notebook 所有笔记
     *
     */
    public function getNotebook($notebookID, $userID){
        return $this->notebookDao->getNotebook($notebookID, $userID);
    }

    /**
     * 用于获取一个用户的所有笔记本ID
     *
     * @param $userID string 用户ID
     * @return array 所有笔记本ID
     *
     */
    public function getUserNotebookID($userID){
        return $this->notebookDao->getUserNotebookID($userID);
    }

    /**
     * 用于获取一个用户的所有笔记本
     *
     * @param $userID string 用户ID
     * @return array 所有笔记本
     *
     */
    public function getUserNotebook($userID){
        return $this->notebookDao->getUserNotebook($userID);
    }

    /**
     * 用于修改指定ID笔记本
     *
     * @param $notebook Notebook
     * @param $preNotebookID string
     * @return boolean 是否成功添加
     */
    public function modifyNotebook($notebook, $preNotebookID){
        if(strcmp($notebook->getNotebookID(), $preNotebookID) == 0){
            return $this->modifyOneNotebook($notebook);
        } else{
            return $this->modifyNotebookID($notebook, $preNotebookID);
        }
    }

    /**
     * 用于添加笔记本
     *
     * @param $notebook Notebook
     * @return boolean 是否成功添加
     * @throws NotebookExistedException
     */
    public function addNotebook($notebook){
        $notebook_temp = $this->getNotebook($notebook->getNotebookID(), $notebook->getUserID());
        if(!is_null($notebook_temp)){
            throw new NotebookExistedException();
        }

        return $this->notebookDao->addNotebook($notebook);
    }

    /**
     * 用于删除笔记本
     *
     * @param $notebookID string 笔记本ID
     * @param $userID string 用户ID
     * @return boolean 是否成功删除
     *
     */
    public function removeNotebook($notebookID, $userID){
        return $this->notebookDao->removeNotebook($notebookID, $userID);
    }

    /**
     * 修改笔记本的内容
     *
     * @param $notebook Notebook
     * @return boolean 是否成功修改
     */
    private function modifyOneNotebook($notebook){
        return $this->notebookDao->modifyNotebook($notebook);
    }

    /**
     * 修改笔记本的ID
     *
     * @param $notebook Notebook
     * @param $preNotebookID string
     * @return boolean 是否成功修改
     * @throws NotebookExistedException
     */
    private function modifyNotebookID($notebook, $preNotebookID){
        $notebook_temp = $this->getNotebook($notebook->getNotebookID(), $notebook->getUserID());
        if(!is_null($notebook_temp)){
            throw new NotebookExistedException();
        }

        $noteIDs = $this->noteService->getNoteID($preNotebookID, $notebook->getUserID());
        for ($i = 0;$i<count($noteIDs);$i++){
            $item = $noteIDs[$i];
            $note = $this->noteService->getOneNote($notebook->getUserID(), $preNotebookID, $item['noteID']);
            $this->noteService->removeNote($notebook->getUserID(), $preNotebookID, $item['noteID']);
            $note->setNotebookID($notebook->getNotebookID());
            $this->noteService->addNote($note);
        }

        $this->removeNotebook($preNotebookID, $notebook->getUserID());
        return $this->addNotebook($notebook);
    }

    /**
     * @param $info string
     * @param $userID string
     * @return array
     */
    public function searchNotebook($info, $userID){
        return $this->notebookDao->searchNotebook($info, $userID);
    }

}