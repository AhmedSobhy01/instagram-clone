(()=>{var e,t,r=document.getElementById("profile-image-form"),n=document.getElementById("profile-image-file"),o=$("#profileImageModal"),a=document.getElementById("image-preview"),i=document.getElementById("upload"),s=["image/png","image/jpeg"];function d(e){e?(i.disabled=!0,i.style.cursor="no-drop",i.querySelector("div").classList.remove("d-none")):(i.disabled=!1,i.style.cursor="pointer",i.querySelector("div").classList.add("d-none"))}function l(e){e?document.querySelector(".full-loader").classList.remove("d-none"):document.querySelector(".full-loader").classList.add("d-none")}function c(e){toastr.error(e,"Image Invalid!",{closeButton:!0,newestOnTop:!0,progressBar:!0,showDuration:"300",hideDuration:"1000",timeOut:"5000",extendedTimeOut:"5000"})}n.accept=s.join(","),n.multiple=!1,n.addEventListener("change",(function(r){if(r.preventDefault(),r.stopPropagation(),r.target.files&&r.target.files.length>0){if(!function(e){if(!e)return;if(!s.includes(e.type))return c("Invalid file type."),!1;if(e.size>=1e7)return c("Maximum image size is ".concat(10," MB.")),!1;return!0}(r.target.files[0]))return;l(!0),(t=new FileReader).addEventListener("load",(function(t){a.src=t.target.result,e=new Cropper(a,{aspectRatio:1,viewMode:3,preview:".preview"}),l(!1),o.modal("show")})),t.readAsDataURL(n.files[0])}})),o.on("hidden.bs.modal",(function(){e.destroy(),e=null,n.value="",a.src="",a.parentElement.querySelectorAll("div").forEach((function(e){return e.remove()})),d(!1),document.querySelector(".preview").innerHTML=""})),i.addEventListener("click",(function(n){n.preventDefault(),n.stopPropagation(),d(!0),canvas=e.getCroppedCanvas({width:500,height:500}),canvas.toBlob((function(e){url=URL.createObjectURL(e),t.readAsDataURL(e),t.addEventListener("load",(function(){var e=t.result;axios.patch(r.action,{_token:$('meta[name="_token"]').attr("content"),image:e}).then((function(e){return e.data})).then((function(t){200==t.response_code&&(document.querySelector("#profile-image-form img").src=e,o.modal("hide"),toastr.success(t.error_message,t.error_title))})).catch((function(e){401==e.response.status?window.location=e.response.data.redirectUrl:toastr.error(e.response.data.error_message,e.response.data.error_title,{closeButton:!0,progressBar:!0,positionClass:"toast-top-right",preventDuplicates:!0,showDuration:300,hideDuration:1e3,timeOut:5e3,extendedTimeOut:5e3,showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut"})}))}))}))}))})();