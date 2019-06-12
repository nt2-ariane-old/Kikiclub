window.onload = () =>{
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