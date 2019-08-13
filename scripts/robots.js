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
