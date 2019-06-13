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