let members;
const searchMember = (node,type,keycode) =>
{
	if(keycode === 13)
	{
		post("today-members.php",{"list":null,"members_list":members});
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
                        console.log(data);
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

const onPageLoad = () =>
{
    let feelds = ['firstname','lastname','email'];
	feelds.forEach(feeld => {
		let node = document.getElementById('search-member-' + feeld);
		if(node != null)
		{
			node.addEventListener("keyup",function(event){
				searchMember (node,feeld,event.keyCode)
			 });
		}

	});
}