<?php

/**
 * @author     Jean-Marie HOLLAND <illaweb35@gmail.com>
 * @copyright  (c) 2018, Jean-Marie HOLLAND. All Rights Reserved.
 * @license    Lesser General Public Licence <http://www.gnu.org/copyleft/lesser.html>
 * @link       https://illaweb.fr
 */

namespace Src\Controllers;

use App\Viewer;


class Front extends Main
{

    public function Index()
    {
        $billets = $this->billetManager->ReadFront(0, \MAX_POST);
        $view = new Viewer('Front/Index', 'Alaska _ Accueil');
        $view->createFile(['billets' => $billets]);
    }

    public function Posting($id)
    {
        $billets = $this->billetManager->Read($id);
        $comments = $this->commentManager->Read($id);
        $view = new Viewer('Front/Post', 'Alaska _ Détails d\'un article');
        $view->createFile(['billets' => $billets, 'comments' => $comments]);
    }

    public function ListPost()
    {
        $billets = $this->billetManager->ReadFront(0, 100);
        $view = new Viewer('Front/List', 'Alaska _ Liste des billets');
        $view->createFile(['billets' => $billets]);
    }

    public function Create_com()
    {
        $comment = $this->commentManager->Create();
        if ($comment !== false) {
            header('Location:' . \BASEPATH . 'Front/Posting/' . $comment);
            exit();
        }
    }

    public function Signaler($id)
    {
        $comment = $this->commentManager->Moderate($id);
        if ($comment !== false) {
            header('Location:' . \BASEPATH . 'Front/Posting/' . $comment);
            exit();
        }
    }
}
