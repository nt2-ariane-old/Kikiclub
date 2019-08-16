let dropzone;
const adminLoad = () =>
{

	document.addEventListener("click", (e) => {
		closeAllLists(e.target);
	});


	if(document.querySelector("#drop-workshop") != null)
	{
		$(function() {
			dropzone = new Dropzone("div#drop-workshop",
				{ url: "ajax/media-ajax.php",
					params: {
						dir: "images/uploads/workshops"
					 }
				});
			dropzone.on("success", function(file,infos) {
				infos = JSON.parse(infos);
				console.log()
				if(typeof(infos) === "string")
				{
					alert(infos);
				}
				else
				{
					let media_path = document.getElementById('media_path');
					media_path.value = infos["path"];

					let media_type = document.getElementById('media_type');
					media_type.value = infos["type"];

					let media = document.querySelector("#current-media");
					media.innerHTML = "";

					loadMedia({"media_path":infos["path"],"media_type":infos["type"]},media);
				}
			});
		})
	}

	$('table.memberTable th') .click(
		function() {
			$(this) .parents('table.memberTable') .children('tbody') .toggle();
		}
	)

	$('table.usersTable tr.rowMember th') .click(
		function() {
			$(this) .parents('table.usersTable') .children('tbody') .toggle();
		}
	)

	activateDraggable();

	let nodeAll = document.getElementById('search-all');
		if(nodeAll != null)
		{
			nodeAll.addEventListener("keyup",function(event){
				searchAll(nodeAll,event.keyCode);
			 });
		}

	let feelds = ['firstname','lastname','email'];
	feelds.forEach(feeld => {
		let node = document.getElementById('search-user-' + feeld);
		if(node != null)
		{
			node.addEventListener("keyup",function(event){
				searchUsers (node,feeld,event.keyCode)
			 });
		}

		if(feeld != 'email')
		{
			let nodeM = document.getElementById('search-member-' + feeld);
				if(nodeM != null)
				{
					nodeM.addEventListener("keyup",function(event){
						searchMember (nodeM,feeld,event.keyCode)
					});
				}
		}

	});


}
let users;
const searchUsers = (node,type,keycode) =>
{
	if(keycode === 13)
	{
		post("users.php",{"list":null,"users_list":users});
	}
	$( function() {
		id = "#" + node.id;
		$( id).autocomplete({
			source: function(request,response)
			{
				$.ajax({
					type: "POST",
					url:"ajax/search-ajax.php",
					data: {
						'name':node.value,
						'search-user': true,
						'type':type,
					},
					dataType: 'json',
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 0,
			select: function( event, ui ) {
				node.value = ui.item.label;
				post("console.php",{"update":null,"users":null,"users_list[]":ui.item.value})


			},
			response: function (event, ui) {
				users = JSON.stringify(ui.content)

    	}
		});
	} );
}
let all_list = [];
const searchAll = (node,keycode) =>
{
	if(keycode === 13)
	{
		post("users.php",{"list":null,"users_and_member_list":all_list});
	}
	$( function() {
		id = "#" + node.id;
		$( id).autocomplete({
			source: function(request,response)
			{
				$.ajax({
					type: "POST",
					url:"ajax/search-ajax.php",
					data: {
						'name':node.value,
						'search-all-feelds': true
					},
					dataType: 'json',
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 0,
			select: function( event, ui ) {
				node.value = ui.item.label;
				if(ui.item.type == "user")
				{
					change_page("manage-user.php",{"user_id":ui.item.value,"users_action":"update"});


				}
				if(ui.item.type == "member")
				{
					change_page("manage-member.php",{"member_id":ui.item.value,"members_action":"update"});
				}
			},
			response: function (event, ui) {
				all_list = JSON.stringify(ui.content);
    	}
		});
	} );
}
let members;
const searchMember = (node,type,keycode) =>
{
	if(keycode === 13)
	{
		post("users.php",{"list":null,"members_list":members});
	}
	$( function() {
		id = "#" + node.id;
		$( id).autocomplete({
			source: function(request,response)
			{
				$.ajax({
					type: "POST",
					url:"ajax/search-ajax.php",
					data: {
						'name':node.value,
						'search-member': true,
						'type':type,
					},
					dataType: 'json',
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 0,
			select: function( event, ui ) {
				node.value = ui.item.label;
				change_page("member-home.php",{"member_id":ui.item.value});
			},
			response: function (event, ui) {
				members = JSON.stringify(ui.content)
    	}
		});
	} );
}

// const sendEmail = (workshop) =>
// {
// 	let formData = new FormData();
// 	formData.append("workshop",JSON.stringify(workshop));
// 	// fetch("send-email-ajax.php", {
// 	// 	method: "POST",
// 	// 	credentials: 'include',
// 	// 	body: formData
// 	// })
// 	// .then(response => response.json())
// 	// .then(data => {
// 	// 	if(data.length > 0)
// 	// 	{
// 	// 		alert("Envoyer a " + data.length + " personnes");
// 	// 	}
// 	// 	else
// 	// 	{
// 	// 		alert("Erreur d'envois");
// 	// 	}
// 	// });
// }

const searchRobots = () =>
{
	let node= document.querySelector("#search-barRobots");
	let table = document.querySelector("#table-robots");
	let formData = new FormData();

	formData.append('name', node.value);
	formData.append('robots',true);

	fetch("ajax/search-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		table.innerHTML = "";
		data.forEach(robot => {
			let line = document.createElement("TR");

			//Add Checkbox
			let checkCase = document.createElement("TD");

			let checkbox = document.createElement("INPUT");
				checkbox.setAttribute("type", "checkbox");
				checkbox.setAttribute("name", "robots_list[]");
				checkbox.setAttribute("value", robot["ROBOTS"]["id"]);
				checkCase.appendChild(checkbox);

			//ID
			let caseId = document.createElement("TD");
				caseId.innerHTML =robot["ROBOTS"]["id"];

			//NAME
			let casename= document.createElement("TD");
				casename.innerHTML =robot["ROBOTS"]["name"];

			//SCORES
			let caseScores = document.createElement("TD");
			if(robot["SCORES"].length > 0){
				//CREATION OF TABLE
				let tableScores = document.createElement("table");
				tableScores.style.width = '100%';
				tableScores.setAttribute("class", "scoresTable");

				//HEAD OF TABLE OF FAMILY MEMBER
				let head = document.createElement("thead");
					let ScoreLine = document.createElement("tr");
						let thFirst = document.createElement("th");
							thFirst.innerHTML = "Difficulty";
							thFirst.style.width = '50%';
							ScoreLine.appendChild(thFirst);

						let thLast = document.createElement("th");
							thLast.innerHTML = "Score";
							thLast.style.width = '50%';
							ScoreLine.appendChild(thLast);
					head.appendChild(ScoreLine);
					tableScores.appendChild(head);

				let body = document.createElement("tbody");
					robot["SCORES"].forEach(difficulty => {
						Scoreline = document.createElement("tr");
						//DIFFICULTY
						let tdDiff =document.createElement("td");
							tdDiff.innerHTML =difficulty["DIFFICULTY"];
						//SCORES
						let tdScore =document.createElement("td");
							tdScore.innerHTML =difficulty["SCORE"];

							Scoreline.appendChild(tdDiff);
							Scoreline.appendChild(tdScore);
						body.appendChild(Scoreline);
					});

					tableScores.appendChild(body);

					caseScores.appendChild(tableScores);
					line.appendChild(caseScores);
			}

			line.appendChild(checkCase);
			line.appendChild(caseId);
			line.appendChild(casename);
			line.appendChild(caseScores);

			table.appendChild(line);
		});
	});
}

const activateDraggable = () => {
	console.log('dragable-activated')
	let dropped = false;
	let draggable_sibling;

	$( "ul.droppable" ).sortable({
	  	connectWith: "ul",
	  	start: function(event, ui) {
		},
		over: function(event, ui) {
			setWorkshopToCategory(parseInt(ui.item[0].id),event.target.id,true);
		}


	});

	$( "#new,#complete, #not-started, #in-progress" ).disableSelection();

}

const setWorkshopToCategory = (id_workshop, category, adding) =>
{
	let formData = new FormData();
	formData.append('id_workshop', id_workshop);
	formData.append('category',category );
	formData.append('adding', adding);

	fetch("ajax/familyWorkshops-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.text())
	.then(data => {

	})

	if(adding)
	{
		switch(category)
		{
			case 'in-progress':
			break;
			case 'not-started':
			break;
			case 'complete':
			break;
		}
	}
	else
	{
		switch(category)
		{
			case 'in-progress':
			break;
			case 'not-started':
			break;
			case 'complete':
			break;
		}
	}
}

const addquestion = () =>
{
	let node = document.getElementById("questions");
	let nbQuestions = document.getElementById("nbQuestions");
	nbQuestions.value = parseInt(nbQuestions.value) + 1;

	let contents = document.createElement("div");
	contents.setAttribute("class", "questions-answers");

	let para = document.createElement("p");
	var txtNode = document.createTextNode("Question " + nbQuestions.value );
	para.appendChild(txtNode);

	let question = document.createElement("INPUT");
	question.setAttribute("type", "text");
	question.setAttribute("name", "questions[]");
	question.setAttribute("placeholder", "Question");

	let answer = document.createElement("INPUT");
	answer.setAttribute("type", "text");
	answer.setAttribute("name", "answers[]");
	answer.setAttribute("placeholder", "Answer");

	contents.appendChild(para);
	contents.appendChild(question);
	contents.appendChild(answer);

	node.appendChild(contents);
}

const searchWorkshop = () =>
{
	let node= document.querySelector("#search-bar");
	let table = document.querySelector(".tableValue");
	let formData = new FormData();
	formData.append('name', node.value);
	formData.append('workshop',true);

	fetch("ajax/search-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {

		table.innerHTML = "";

		data.forEach(workshop => {
			let line = document.createElement("TR");
			if(workshop["DEPLOYED"])
			{
				line.style.backgroundColor = "GREEN";
			}
			else
			{
				line.style.backgroundColor = "RED";
			}
			//Add Checkbox
			let checkCase = document.createElement("TD");

			let checkbox = document.createElement("INPUT");
				checkbox.setAttribute("type", "checkbox");
				checkbox.setAttribute("name", "workshops_list[]");
				checkbox.setAttribute("value", workshop["id"]);
				checkbox.setAttribute("class","checkbox");
				checkCase.appendChild(checkbox);

			//Add Media
			let caseMedia = document.createElement("TD");
			let media;

			if(workshop["MEDIA_TYPE"] == "mp4")
			{
				media = document.createElement("VIDEO");
				media.setAttribute("width", "100");
				media.setAttribute("height", "100");

				let source =document.createElement("SOURCE");
				source.setAttribute("src", workshop["media_path"]);
				source.setAttribute("type", "video/"+workshop["media_type"]);
				media.appendChild(source);
			}
			else if( workshop["MEDIA_TYPE"] == "png" ||
					workshop["MEDIA_TYPE"] == "jpg")
			{
				media = document.createElement("img");
				media.style.width = "100px";
				media.src =workshop["media_path"];
			}
			else if(workshop["MEDIA_TYPE"] == "mp3")
			{
				media = document.createElement("audio");
				media.src = workshop["media_path"];
				media.controls="controls";
				media.innerHTML = "Your browser does not support the audio element.";
			}
			else
			{
				media = document.createElement("div");
			}
			caseMedia.appendChild(media);

			//NAME
			let caseName = document.createElement("TD");
			let name = document.createElement("h5");
				name.innerHTML =workshop["name"];
				caseName.appendChild(name);

			//CONTENT
			let caseContent = document.createElement("TD");
			let content = document.createElement("p");
				content.innerHTML =workshop["content"];
				caseContent.appendChild(content);
			//DIFFICULTY
			let caseDifficulty = document.createElement("TD");
			let difficulty = document.createElement("p");
				difficulty.innerHTML =workshop["ID_DIFFICULTY"];
				caseDifficulty.appendChild(difficulty);
			//ROBOT
			let caseRobot = document.createElement("TD");
			let robot = document.createElement("p");
				robot.innerHTML =workshop["ID_ROBOT"];
				caseRobot.appendChild(robot);

			line.appendChild(checkCase);
			line.appendChild(caseMedia);
			line.appendChild(caseName);
			line.appendChild(caseContent);
			line.appendChild(caseDifficulty);
			line.appendChild(caseRobot);

			table.appendChild(line);
		});
	});

}
const checkAll = () =>
{
	let checks = document.querySelectorAll("input[type='checkbox']");
	let checking = true;
	let invert = false;
	while(checking)
	{
		checking = false;
		let counter = 0;
		checks.forEach(element => {
			if(!element.hasAttribute('checked'))
			{
				counter++;
			}

			if(invert)
			{
				element.removeAttribute('checked');
			}
			else
			{
				element.setAttribute('checked','checked');
			}
		});
		console.log(counter);
		if(counter == 0 && !invert)
		{
			invert = true;
			checking = true;
		}
	}

}
const fillUserTable = (data) =>
{
	let table = document.querySelector("#table-users");

	table.innerHTML = "";

	data.forEach(user => {
		let line = document.createElement("TR");

		//Add Checkbox
		let checkCase = document.createElement("TD");

		let checkbox = document.createElement("INPUT");
			checkbox.setAttribute("type", "checkbox");
			checkbox.setAttribute("name", "users_list[]");
			checkbox.setAttribute("value", user["USER"]["id"]);
			checkCase.appendChild(checkbox);

			//ID
			let caseId = document.createElement("TD");
				caseId.innerHTML =user["USER"]["id"];

			//FIRSTNAME
			let casefirst = document.createElement("TD");
				casefirst.innerHTML =user["USER"]["FIRSTNAME"];
			//LASTNAME
			let caseLast = document.createElement("TD");
				caseLast.innerHTML =user["USER"]["LASTNAME"];

			//EMAIL
			let caseEmail = document.createElement("TD");
				caseEmail.innerHTML =user["USER"]["EMAIL"];

			//FAMILY
			let caseFamily = document.createElement("TD");
			if(user["FAMILY"].length > 0){
				//CREATION OF TABLE
				let tableFamily = document.createElement("table");
				tableFamily.style.width = '100%';
				tableFamily.setAttribute("class", "memberTable");

				//HEAD OF TABLE OF FAMILY MEMBER
				let head = document.createElement("thead");
					let Familyline = document.createElement("tr");
						let thSelect = document.createElement("th");
							thSelect.innerHTML = "Select";
							thSelect.style.width = '5%';
							Familyline.appendChild(thSelect);

						let thID = document.createElement("th");
							thID.innerHTML = "id";
							thID.style.width = '10%';
							Familyline.appendChild(thID);

						let thFirst = document.createElement("th");
							thFirst.innerHTML = "First Name";
							thFirst.style.width = '25%';
							Familyline.appendChild(thFirst);

						let thLast = document.createElement("th");
							thLast.innerHTML = "Last Name";
							thLast.style.width = '25%';
							Familyline.appendChild(thLast);

						let thBirth = document.createElement("th");
							thBirth.innerHTML = "Birthday";
							thBirth.style.width = '25%';
							Familyline.appendChild(thBirth);

						let thScore = document.createElement("th");
							thScore.innerHTML = "Score";
							thScore.style.width = '10%';
							Familyline.appendChild(thScore);
					head.appendChild(Familyline);
					tableFamily.appendChild(head);

				let body = document.createElement("tbody");
					user["FAMILY"].forEach(member => {
						Familyline = document.createElement("tr");

						//CHECK
						let tdCheck = document.createElement("TD");

						let checkboxFamily  = document.createElement("INPUT");
							checkboxFamily.setAttribute("type", "checkbox");
							checkboxFamily.setAttribute("name", "members_list[]");
							checkboxFamily.setAttribute("value", member["id"]);
							tdCheck.appendChild(checkboxFamily);
						//ID
						let tdId =document.createElement("td");
							tdId.innerHTML =member["id"];
						//FIRST
						let tdFirst =document.createElement("td");
							tdFirst.innerHTML =member["FIRSTNAME"];
						//LAST
						let tdLast =document.createElement("td");
							tdLast.innerHTML =member["LASTNAME"];
						//BIRTH
						let tdBirth =document.createElement("td");
							tdBirth.innerHTML =member["BIRTHDAY"];
						//SCORE
						let tdScore =document.createElement("td");
							tdScore.innerHTML =member["SCORE"];

							Familyline.appendChild(tdCheck);
							Familyline.appendChild(tdId);
							Familyline.appendChild(tdFirst);
							Familyline.appendChild(tdLast);
							Familyline.appendChild(tdBirth);
							Familyline.appendChild(tdScore);

						body.appendChild(Familyline);
					});

					tableFamily.appendChild(body);

					caseFamily.appendChild(tableFamily);
					line.appendChild(caseFamily);
			}

			line.appendChild(checkCase);
			line.appendChild(caseId);
			line.appendChild(casefirst);
			line.appendChild(caseLast);
			line.appendChild(caseEmail);
			line.appendChild(caseFamily);

			table.appendChild(line);

	});
}


const closeAllLists = (element,input) => {
    let lists = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < lists.length; i++) {
      if (element != lists[i] && element != input) {
		lists[i].parentNode.removeChild(lists[i]);
    }
  }
}
const validTab = (form) =>
{
	let valide = true;
	if(clicked=='delete')
	{

		valide = false;
	}
	return valide;
}