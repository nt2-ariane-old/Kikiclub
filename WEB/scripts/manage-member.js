const onPageLoad = () =>
{
	$('#mixedSlider_avatars').multislider({
		interval:0,
	});

	if(document.querySelector('#datepicker') != null)
	{

		$( function() {
			$( "#datepicker" ).datepicker(
				{
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
				showAnim:'slideDown',
				dateFormat:'dd/mm/yy',
				minDate: "-100y",
				maxDate: "-4y",
				yearRange: "1900:2100"
			});

		}
		);
	}
}