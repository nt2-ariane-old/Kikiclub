<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class UsersAction extends CommonAction {


		public $users;
		public $members;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'users',"Home");
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","home");


			unset($_SESSION["member_id"]);
			if(isset($_POST["list"]))
			{

				if(!empty($_POST["users_list"]))
				{
					$searchUsers =json_decode($_POST["users_list"],true);
					foreach ($searchUsers as $user) {
						$id = $user["value"];
						$this->users[] = UsersDAO::getUserWithID($id);
					}

				}
				if(!empty($_POST["members_list"]))
				{

					$searchMembers =json_decode($_POST["members_list"],true);
					foreach ($searchMembers as $member) {
						$id = $member["value"];
						$this->members[] = MemberDAO::selectMember($id);
					}

				}
				if(!empty($_POST["users_and_member_list"]))
				{
					$results =json_decode($_POST["users_and_member_list"],true);
					foreach ($results as $result) {
						$id = $result["value"];

						if($result["type"] == "member")
						{
							$this->members[] = MemberDAO::selectMember($id);
						}
						if($result["type"] == "user")
						{
							$this->users[] = UsersDAO::getUserWithID($id);

						}
					}


				}

			}
			else if(isset($_POST["deployed"]))
			{
				if(!empty($_POST["workshops_list"]))
				{
					$this->deployWorkshops();
				}
			}

		}
	}