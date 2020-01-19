const onPageLoad = () =>
{
	if(document.querySelector("#imagedropzone") != null)
	{
		$(function() {
			dropzone = new Dropzone("div#imagedropzone",
				{ url: "ajax/media-ajax.php",
					params: {
						dir: "images/uploads/robots"
					 }
				});
			dropzone.on("success", function(file,infos) {
				infos = JSON.parse(infos);
				if(typeof(infos) === "string")
				{
					alert(infos);
				}
				else
				{
					let media_path = document.getElementById('media_path');
					media_path.value = infos["path"];

					let media_type = document.getElementById('media_type');
					media_type.value = infos["type"];

					let media = document.querySelector("#current-media");
					media.innerHTML = "";

					loadMedia({"media_path":infos["path"],"media_type":infos["type"]},media);
				}
			});
		})
	}
}