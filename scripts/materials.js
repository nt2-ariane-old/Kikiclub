const onPageLoad = () =>
{

}

const addMaterial = () =>
{
    let parent = document.querySelector('#materials');
    
        let p = document.createElement('p');
            p.innerHTML = "Nouveau Matériel : ";

            let input = document.createElement('input');
                input.type = 'text';
            let button = document.createElement('button');
                button.type = "button";
                button.innerHTML = "✓";
                button.onclick = () => createMaterial(input);
            p.appendChild(input);
            p.appendChild(button);

        parent.appendChild(p);
}

const modifycheck = (button) =>
{
    if(button.innerHTML == 'x')
    {
        button.innerHTML = "✓";
        let input = button.parentElement.querySelector('input');
        input.onkeypress = null;
        button.onclick = () => updateMaterial(input);
    }
    else
    {
        button.innerHTML = 'x';
        let input = button.parentElement.querySelector('input');
        input.onkeypress = () => modifycheck(button);
        button.onclick = () => deleteMaterial(input);
    }
}

const createMaterial = (input) =>
{
    let value = input.value;
    let node = input;
    $.ajax({
		type: "POST",
		url:'ajax/material-ajax.php',
		data:
		 {
            'type':'create',
            'value':value,
		 },
		dataType: 'json',
		success: function( data ) {
			let p = node.parentElement;
            p.innerHTML = "Matériel " + data['id'] + " : ";

            let input = document.createElement('input');
                input.type = 'text';
                input.onkeypress = () => modifycheck(this.parentElement.querySelector('button'));
                input.id = data['id'];
                input.value = data['name'];

            let button = document.createElement('button');
                button.type = "button";
                button.innerHTML = "x";
                button.onclick = () => deleteMaterial(input);

            p.appendChild(input);
            p.appendChild(button);
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}
	});
}
const updateMaterial = (input) =>
{
    let id = input.id;
    let value = input.value;
    $.ajax({
		type: "POST",
		url:'ajax/material-ajax.php',
		data:
		 {
            'type':'update',
            'id':id,
            'value':value,
		 },
		dataType: 'json',
		success: function( data ) {
            modifycheck(input.parentElement.querySelector('button'));
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}
	});
}
const deleteMaterial = (input) =>
{
    let id = input.id;
    $.ajax({
		type: "POST",
		url:'ajax/material-ajax.php',
		data:
		 {
            'type':'delete',
            'id':id,
		 },
		dataType: 'json',
		success: function( data ) {
			let parent = input.parentElement;
            parent.parentElement.removeChild(parent);
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}
	});
}