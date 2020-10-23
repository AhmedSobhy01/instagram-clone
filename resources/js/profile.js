const profileImgForm = document.getElementById("profile-image-form"),
    profileImgFileElm = document.getElementById("profile-image-file"),
    changeProfileImageModal = $("#profileImageModal"),
    imagePreview = document.getElementById("image-preview"),
    uploadBtn = document.getElementById("upload");

let cropper, reader;

const maxImageSize = 10, // In MB
    allowedExtensions = ["image/png", "image/jpeg"];

profileImgFileElm.accept = allowedExtensions.join(",");
profileImgFileElm.multiple = false;

profileImgFileElm.addEventListener("change", e => {
    e.preventDefault();
    e.stopPropagation();

    if (e.target.files && e.target.files.length > 0) {
        let img = e.target.files[0];

        if (!validateFile(img)) return;

        loaderStatus(true);

        reader = new FileReader();

        reader.addEventListener("load", e => {
            imagePreview.src = e.target.result;
            cropper = new Cropper(imagePreview, {
                aspectRatio: 1,
                viewMode: 3,
                preview: ".preview"
            });
            loaderStatus(false);
            changeProfileImageModal.modal("show");
        });

        reader.readAsDataURL(profileImgFileElm.files[0]);
    }
});

changeProfileImageModal.on("hidden.bs.modal", () => {
    cropper.destroy();
    cropper = null;
    profileImgFileElm.value = "";
    imagePreview.src = "";
    imagePreview.parentElement
        .querySelectorAll("div")
        .forEach(div => div.remove());
    uploadStatus(false);
    document.querySelector(".preview").innerHTML = "";
});

uploadBtn.addEventListener("click", e => {
    e.preventDefault();
    e.stopPropagation();
    uploadStatus(true);

    canvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        reader.readAsDataURL(blob);

        reader.addEventListener("load", () => {
            var base64data = reader.result;

            axios
                .patch(profileImgForm.action, {
                    _token: $('meta[name="_token"]').attr("content"),
                    image: base64data
                })
                .then(res => res.data)
                .then(data => {
                    if (data.response_code == 200) {
                        document.querySelector(
                            "#profile-image-form img"
                        ).src = base64data;
                        changeProfileImageModal.modal("hide");
                        toastr.success(data.error_message, data.error_title);
                    }
                })
                .catch(err => {
                    if (err.response.status == 401) {
                        window.location = err.response.data.redirectUrl;
                    } else {
                        toastr.error(
                            err.response.data.error_message,
                            err.response.data.error_title,
                            {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                preventDuplicates: true,
                                showDuration: 300,
                                hideDuration: 1000,
                                timeOut: 5000,
                                extendedTimeOut: 5000,
                                showEasing: "swing",
                                hideEasing: "linear",
                                showMethod: "fadeIn",
                                hideMethod: "fadeOut"
                            }
                        );
                    }
                });
        });
    });
});

function uploadStatus(status) {
    if (status) {
        uploadBtn.disabled = true;
        uploadBtn.style.cursor = "no-drop";
        uploadBtn.querySelector("div").classList.remove("d-none");
    } else {
        uploadBtn.disabled = false;
        uploadBtn.style.cursor = "pointer";
        uploadBtn.querySelector("div").classList.add("d-none");
    }
}

function loaderStatus(status) {
    if (status) {
        document.querySelector(".full-loader").classList.remove("d-none");
    } else {
        document.querySelector(".full-loader").classList.add("d-none");
    }
}

function showErr(message) {
    toastr.error(message, "Image Invalid!", {
        closeButton: true,
        newestOnTop: true,
        progressBar: true,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "5000"
    });
}

function validateFile(file) {
    if (!file) return;

    if (!allowedExtensions.includes(file.type)) {
        showErr("Invalid file type.");
        return false;
    }

    if (file.size >= maxImageSize * 1000 * 1000) {
        showErr(`Maximum image size is ${maxImageSize} MB.`);
        return false;
    }

    return true;
}
