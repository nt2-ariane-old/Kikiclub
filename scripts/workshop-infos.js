const onPageLoad = () =>
{

}

let params = [];
params["difficulties"] = [];
params["grades"] = [];
params["robots"] = [];

const setParams = (type,value) =>
{
	if(params[type].indexOf(value) > -1)
	{
		params[type].splice(params[type].indexOf(value),1);
	}
	else
	{
		params[type].push(value);
	}

	applyParams();
}

const deleteParams = () =>
{
	params["difficulties"] = [];
	params["grades"] = [];
	params["robots"] = [];
	let filters = document.querySelectorAll("input[type='checkbox']");
	filters.forEach(filter => {
		filter.checked = false;
	});
	applyParams();
}

const applyParams = () =>
{
	let div = document.querySelector("#params");
	div.innerHTML = "";

	Object.keys(params).forEach(function(key){
		let value = params[key];
		value.forEach(element => {
			let input = document.createElement('input');
				input.setAttribute('type','hidden');
				input.setAttribute('name',key+"[]");
				input.setAttribute('value',element);
			div.appendChild(input);
		});
	 });

}