Dropzone.autoDiscover = false;

const onPageLoad = () =>
{
	ClassicEditor
	.create( document.querySelector( '#content' ), {
		// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( err => {
		console.error( err.stack );
	} );

	$(function() {

		var myDropzone = new Dropzone("#imagedropzone");

		myDropzone.on("success", function(file,infos) {
			infos = JSON.parse(infos);
			let media_path = document.getElementById('media_path');
			media_path.value = infos["PATH"];
			let media_type = document.getElementById('media_type');
			media_type.value = infos["TYPE"];
		});
	})

}

let page = 0;

const setPage = new_page =>
{
	page = new_page;
	loadPosts();
}
const loadPosts = (action=null,id=null) =>
{
	let formData = new FormData();

	formData.append(action, '');
	formData.append('page',page);
	if(action=='insert')
	{
		let title = document.getElementById('title');
		let content = document.getElementById('content');

		formData.append('title', title.value);
		formData.append('content', content.value);

		title.value = "";
		content.value = "";
	}
	else if(action=='delete')
	{
		formData.append('id', id);
	}
	fetch("posts-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		posts = data["posts"];
		nbPages = data["nbPages"];
		let container = document.getElementById('shared-posts');
		container.innerHTML = "";
		posts.forEach(post => {
			let postArticle = document.createElement('article');
				postArticle.setAttribute('class','post');

				let user = document.createElement('h5');
					user.innerHTML =post["USERNAME"];
					user.setAttribute('class', 'username');
				let title = document.createElement('h3');
					title.innerHTML = post["TITLE"];
					title.setAttribute('class', 'title');

				let content = document.createElement('p');
					content.innerHTML =  post["CONTENT"];
					content.setAttribute('class', 'content');

				postArticle.appendChild(user);
				postArticle.appendChild(title);
				postArticle.appendChild(content);
				loadMedia(post,postArticle)
				if(isUser(post["ID_USER"]))
				{
					let deleteButton = document.createElement("button");
						deleteButton.setAttribute('onclick',"loadPosts('delete', " + post["ID"]+")");
						deleteButton.innerHTML = 'Delete';
					postArticle.appendChild(deleteButton);
				}
			container.appendChild(postArticle);

		});

		let containerPages = document.getElementById('pages');
			containerPages.innerHTML = "";

		for (let i = 0; i < nbPages; i++) {
			pageIndex = i + 1;
			let btn = document.createElement('button');
				btn.setAttribute('class','pageBtn');
				btn.setAttribute('onclick','setPage(' + i + ')');
				btn.innerHTML = pageIndex;
			containerPages.appendChild(btn);
		}

	});
}

const isUser = id =>
{
	let valide = false;
	if(id == id)
	{
		valide = true;
	}
	return valide;
}
