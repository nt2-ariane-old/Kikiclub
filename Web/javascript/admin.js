const onPageLoad = () =>
{
	ClassicEditor
	.create( document.querySelector( '#editor' ), {
		// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( err => {
		console.error( err.stack );
	} );

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

}

const activateDraggable = () => {
	$( ".workshop-object" ).draggable();
	$( ".droppable").droppable({
	  accept: ".workshop-object",
	  hoverClass: ".workshop-object-hover",
	  activeClass: "ui-state-highlight",
	  snap: ".workshop-object",
      snapMode: "inner",
	  classes: {
		"ui-droppable-active": "ui-state-active",
		"ui-droppable-hover": "ui-state-hover"
	  },
	  drop: function( event, ui ) {
		this.style.backgroundColor = "red";
		console.log(ui.draggable[0].id);
		console.log(event.target.id);
		setWorkshopToCategory(ui.draggable[0].id,event.target.id,true);
		},
		out: function(event,ui) {
			this.style.backgroundColor = "gray";

		}
	});
}

const setWorkshopToCategory = (id_workshop, category, adding) =>
{
	let formData = new FormData();
	formData.append('id_workshop', id_workshop);
	formData.append('category',category );
	formData.append('adding', adding);

	fetch("familyWorkshops-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
		if(data = 'valide')
		{
			console.log('deplacement accepter')
		}
		else
		{
			console.log('il y a eu une erreur...')
		}
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

const researchWorkshop = () =>
{
	let node= document.querySelector("#research-bar");
	let table = document.querySelector(".tableValue");
	let formData = new FormData();
	formData.append('name', node.value);
	formData.append('workshop',true);

	fetch("research-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {

		table.innerHTML = "";

		data.forEach(workshop => {
			let line = document.createElement("TR");

			//Add Checkbox
			let checkCase = document.createElement("TD");

			let checkbox = document.createElement("INPUT");
				checkbox.setAttribute("type", "checkbox");
				checkbox.setAttribute("name", "workshops_list[]");
				checkbox.setAttribute("value", workshop["ID"]);
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
				source.setAttribute("src", workshop["MEDIA_PATH"]);
				source.setAttribute("type", "video/"+workshop["MEDIA_TYPE"]);
				media.appendChild(source);
			}
			else if( workshop["MEDIA_TYPE"] == "png" ||
					workshop["MEDIA_TYPE"] == "jpg")
			{
				media = document.createElement("img");
				media.style.width = "100px";
				media.src =workshop["MEDIA_PATH"];
			}
			else if($workshop["MEDIA_TYPE"] == "mp3")
			{
				media = document.createElement("audio");
				media.src = $workshop["MEDIA_PATH"];
				media.controls="controls";
				media.innerHTML = "Your browser does not support the audio element.";
			}
			caseMedia.appendChild(media);

			//NAME
			let caseName = document.createElement("TD");
			let name = document.createElement("h5");
				name.innerHTML =workshop["NAME"];
				caseName.appendChild(name);

			//CONTENT
			let caseContent = document.createElement("TD");
			let content = document.createElement("p");
				content.innerHTML =workshop["CONTENT"];
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

const researchMember = () =>
{
	let node= document.querySelector("#research-barUsers");
	let table = document.querySelector("#table-users");
	let formData = new FormData();
	formData.append('name', node.value);
	formData.append('user',true);

	fetch("research-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data);

		table.innerHTML = "";

		data.forEach(user => {
			let line = document.createElement("TR");

			//Add Checkbox
			let checkCase = document.createElement("TD");

			let checkbox = document.createElement("INPUT");
				checkbox.setAttribute("type", "checkbox");
				checkbox.setAttribute("name", "users_list[]");
				checkbox.setAttribute("value", user["USER"]["ID"]);
				checkCase.appendChild(checkbox);

			//ID
			let caseId = document.createElement("TD");
				caseId.innerHTML =user["USER"]["ID"];

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
			console.log(user["FAMILY"].length)
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
							thID.innerHTML = "ID";
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
							checkboxFamily.setAttribute("value", member["ID"]);
							tdCheck.appendChild(checkboxFamily);
						//ID
						let tdId =document.createElement("td");
							tdId.innerHTML =member["ID"];
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
	});
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