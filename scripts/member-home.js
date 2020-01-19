const onPageLoad = () =>
{
	$('#mixedSlider_badges').multislider({
		interval:0,
	});
}

const show = (id,link) =>
{
	let node = document.getElementById(id);
	if(node != null)
	{
		if(node.offsetHeight > 180)
		{
			node.style = "height:180px;"
			link.innerHTML = read("member-home",'show-more');
		}
		else
		{
			node.style = "height:auto;"
			link.innerHTML = read("member-home",'show-less');

		}
	}
	else
	{
	}
}


function openModal() {
	document.getElementById("member_modal").style.display = "block";
  }
  function closeModal() {
	document.getElementById("member_modal").style.display = "none";
  }



const openBadge = ($id) =>
{
	$.ajax({
		type: "POST",
		url:'ajax/badges-ajax.php',
		data:
		 {
			'id':$id
		 },
		dataType: 'json',
		success: function( data ) {
			badge = data["badge"];

			let node = document.getElementById('modal_content');
				node.innerHTML = "";
				let badge_div = document.createElement('div');
					badge_div.setAttribute('class','badges-infos');

				

					loadMedia(badge,badge_div);
					let info = document.createElement('div');
						info.setAttribute('class','infos');

						let name = document.createElement('h2');
							name.innerHTML = badge['name'];

						let desc = document.createElement('p');
							desc.innerHTML = "obtenue pour avoir accumulé " + badge["value_needed"] + " points";
						
						


							info.appendChild(name);
							info.appendChild(desc);
						badge_div.appendChild(info);
				node.appendChild(badge_div);
		},

	});
}