<?php

/**
 * @author    Jean-Marie HOLLAND <illaweb35@gmail.com>
 * @copyright  (c) 2018, Jean-Marie HOLLAND. All Rights Reserved.
 * @license    Lesser General Public Licence <http://www.gnu.org/copyleft/lesser.html>
 * @link       https://illaweb.fr
 */

namespace Src\Controllers;

use App\Viewer;


class Backedit extends Main
{

    public function Create()
    {
        if (!isset($_SESSION['authenticated'])) {
            header('Location:' . \BASEPATH . 'Front/Index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $billets = $this->billetManager->Create();
            if ($billets !== false) {
                header('Location:' . \BASEPATH . 'Back/ListPost');
                exit();
            }
        }
        $billets = $this->billetManager->ReadAll();
        $view = new Viewer('Back/Write', "Alaska _ Ecriture d'un billet");
        $view->createFile(['billets' => $billets]);
    }

    public function Update($id)
    {
        if (!isset($_SESSION['authenticated'])) {
            header('Location:' . \BASEPATH . 'Front/Index');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $billets = $this->billetManager->Update($id);
            if ($billets !== false) {
                header('Location:' . \BASEPATH . 'Back/ListPost');
                exit();
            }
        }

        $billets = $this->billetManager->Read($id);
        $view = new Viewer('Back/Edit_billet', " Alaska _ Modifs d'un billet");
        $view->createFile(['billets' => $billets]);
    }

    public function Create_user()
    {
        if (!isset($_SESSION['authenticated'])) {
            header('Location:' . \BASEPATH . 'Front/Index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $users = $this->userManager->Create();
            if ($users !== false) {
                header('Location:' . \BASEPATH . 'Back/ListUsers');
                exit();
            }
            $view = new Viewer('Back/Users', 'Alaska _ Ajout utilisateur');
            $view->createFile(['users' => $users]);
        }
    }

    public function Update_user($id)
    {
        //Verification si l'utilisateur est bien connecté a l'admin
        if (!isset($_SESSION['authenticated'])) {
            header('Location:' . \BASEPATH . 'Front/Index');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $users = $this->userManager->Update($id);
            if ($users !== false) {
                header('Location:' . \BASEPATH . 'Back/ListUsers');
                exit();
            }
        }
        // Lecture des données existante de l'utilisateur avant modification
        $users = $this->userManager->Read($id);
        $view = new Viewer('Back/Edit_user', 'Alaska _ Modification utilisateur');
        $view->createFile(['users' => $users]);
    }

    public function Delete($id)
    {
        //Verification si l'utilisateur est bien connecté a l'admin
        if (!isset($_SESSION['authenticated']) and !$this->isLogged()) {
            header('Location:' . \BASEPATH . 'Front/Index');
            exit();
        }
        $billets = $this->billetManager->Delete($id);
        header('Location:' . \BASEPATH . 'Back/ListPost');
        exit();
    }

    public function Delete_img($id)
    {
        //Verification si l'utilisateur est bien connecté a l'admin
        if (!isset($_SESSION['authenticated']) and !$this->isLogged()) {
            header('Location:' . \BASEPATH . 'Front/Index');
            exit();
        }

        $billets = $this->billetManager->Delete_img($id);

        header('Location:' . \BASEPATH . 'Backedit/Update/' . $id);
        exit();
    }

    public function Delete_com($id)
    {
        if (!isset($_SESSION['authenticated']) and !$this->isLogged()) {
            header('Location:' . \BASEPATH . 'Front/Index');
        }
        $comments = $this->commentManager->Delete($id);
        header('Location:' . \BASEPATH . 'Back/Dashboard');
        exit();
    }

    public function Delete_user($id)
    {
        if (!isset($_SESSION['authenticated']) and !$this->isLogged()) {
            header('Location:' . \BASEPATH . 'Front/Index');
        }
        $users = $this->userManager->Delete($id);
        header('Location: ' . \BASEPATH . 'Back/ListUsers');
    }
}
