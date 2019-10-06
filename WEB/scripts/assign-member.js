const onPageLoad = () =>
{
	activateDraggable();
}
const activateDraggable = () => {
	let dropped = false;
	let draggable_sibling;

	$( "ul.droppable" ).sortable({
	  	connectWith: "ul",
	  	start: function(event, ui) {
		},
		over: function(event, ui) {
			setWorkshopToCategory(parseInt(ui.item[0].id),event.target.id);
		}


	});

	$( "#new,#complete, #not-started, #in-progress" ).disableSelection();

}

const setWorkshopToCategory = (id_workshop, index) =>
{
    console.log(id_workshop + ' ' + index);
	let formData = new FormData();
	formData.append('id_workshop', id_workshop);
	formData.append('category',index );

	fetch("ajax/member-workshops-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.text())
	.then(data => {	
		console.log(data);
	})
}