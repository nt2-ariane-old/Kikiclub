<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersConnexionDAO.php");

	class ReferenceAction extends CommonAction {
		public $first;
        public $user_token;
        public $error;
        public $success;
        public $msg;
		public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'reference');
            $this->first = false;
		}

		protected function executeAction() {
            if($_SESSION["visibility"] == CommonAction::$VISIBILITY_PUBLIC)
            {
                header('Location:https://kikinumerique.wixsite.com/kikiclubsandbox/blank-5');
            }
            $connexion = UsersConnexionDAO::getUserConnexion($_SESSION["id"]);
            if(sizeof($connexion) <= 1)
            {
                $this->first = true;
            }
            $this->user_token = UsersDAO::getUserWithID($_SESSION["id"])["token"];
            $code = null;
            if(!empty($_POST["code"]) )
            {
                $code = $_POST["code"];
            }
            if(!empty($_SESSION["referral"]))
            {
                $code = $_SESSION["referral"];
                $_SESSION["referral"] = null;
            }
            if(!empty($code))
            {
                if($this->first)
                {
                    $user = UsersConnexionDAO::testRegisterToken(strtoupper($code));
                    if(!empty($user))
                    {
                        if($user["id"] != $_SESSION["id"])
                        {
                            if(UsersConnexionDAO::addReferance($user["id"],$_SESSION["id"]))
                            {
                                
                                $members = MemberDAO::getUserFamily($user["id"]);
                                foreach ($members["family"] as $member) {
                                    MemberDAO::addScore($member["id"],50);
                                }
                                
                                $members = MemberDAO::getUserFamily($_SESSION["id"]);
                                foreach ($members["family"] as $member) {
                                    $member["id"];
                                    MemberDAO::addScore($member["id"],50);
                                }
                                $this->success = true;
                                $this->msg = "Le code à bien été appliqué.";
                            }
                            else
                            {
                                $this->error = true;
                                $this->msg = "Vous avez déjà utilisez ce code...";
                            }
                        }
                        else
                        {
                            $this->error = true;
                            $this->msg = "Vous ne pouvez pas entrez votre propre code de référence.";
                        }
                    }
                    else
                    {
                        $this->error = true;
                        $this->msg = "Le code n'Est pas valide...";
                    }
                }
                else
                {
                    $this->error = true;
                    $this->msg = "Désolé, vous n'êtes pas un nouveau membre...";
                }
            }
            
		}
	}