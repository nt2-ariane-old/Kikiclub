const onPageLoad = () =>
{
	Dropzone.autoDiscover = false;
	$('#mixedSlider').multislider({
		interval:0,
	});


		// document.getElementById('btn-right').onmouseenter = ()=>{$('#mixedSlider').multislider('continuous')}
		// document.getElementById('btn-right').onmouseout = ()=>{$('#mixedSlider').multislider('continuous')}

		let intervalRight;
		document.getElementById('btn-right').onmouseenter = ()=>{
			intervalRight = setInterval(() => { $('#mixedSlider').multislider('next') }, 500);
		}
		document.getElementById('btn-right').onmouseout = ()=>{
			clearInterval(intervalRight);
		}

	let intervalLeft;

	document.getElementById('btn-left').onmouseenter = ()=>{
		intervalLeft = setInterval(() => { $('#mixedSlider').multislider('prev') }, 500);
	}
	document.getElementById('btn-left').onmouseout = ()=>{
		clearInterval(intervalLeft);
	}
}
function openModal() {
	document.getElementById("robot_modal").style.display = "block";
}
function closeModal() {
	document.getElementById("robot_modal").style.display = "none";
}

const loadRobot = (id) =>
{
	let container = document.getElementById("modal_content");
	$.ajax({
		type: "POST",
		url:'ajax/robot-ajax.php',
		data:
		 {
			'id':id
		 },
		dataType: 'json',
		success: function( data ) {
			container.innerHTML = "";
			loadRobotInfos(container,data["robot"],data["grade"]);
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}

	});
}
const loadRobotInfos = (container,robot,robot_grade) =>
{
	let mediaDiv = document.createElement('div');
		mediaDiv.setAttribute('class','media');

		let mediaImg = document.createElement('img');
			mediaImg.src= robot["media_path"];


		mediaDiv.appendChild(mediaImg);

	let secInfos = document.createElement('section');
		
		let nameH3 = document.createElement('h3');
			nameH3.innerHTML = robot["name"];

		let gradeH4 = document.createElement('h4');
			gradeH4.innerHTML = read('robots','grade') + " : " + robot_grade["name"];

		let descDiv = document.createElement('div');
			descDiv.setAttribute('class','description');
			descDiv.innerHTML = robot["description"];

			secInfos.appendChild(nameH3);
			secInfos.appendChild(gradeH4);
			secInfos.appendChild(descDiv);

		container.appendChild(mediaDiv);
		container.appendChild(secInfos);
}
