document
    .getElementById("add-post-btn")
    .addEventListener("click", () => $("#addPostModal").modal("show"));

const imageElm = document.getElementById("image"),
    dropzone = document.getElementById("dropzone"),
    imagePreview = document.getElementById("image-preview"),
    loaderElm = document.getElementById("post-upload-loader"),
    resetBtn = document.getElementById("reset-btn"),
    addPostForm = document.getElementById("addPostForm"),
    uploadBtn = document.getElementById("uploadBtn");

const maxImageSize = 4, // In MB
    allowedExtensions = ["image/png", "image/jpeg"];

imageElm.accept = allowedExtensions.join(",");
imageElm.multiple = false;

dropzone.addEventListener("drag", preventDefault);
dropzone.addEventListener("dragstart", preventDefault);
dropzone.addEventListener("dragend", preventDefault);
dropzone.addEventListener("dragover", preventDefault);
dropzone.addEventListener("dragenter", preventDefault);
dropzone.addEventListener("dragleave", preventDefault);
dropzone.addEventListener("drop", preventDefault);
addPostForm.addEventListener("submit", preventDefault);

resetBtn.addEventListener("click", resetInput);

dropzone.addEventListener("dragover", handleDragOver);
dropzone.addEventListener("dragenter", handleDragOver);

dropzone.addEventListener("dragleave", handleOut);
dropzone.addEventListener("dragend", handleOut);
dropzone.addEventListener("drop", handleOut);

imageElm.addEventListener("change", handleUpload);
dropzone.addEventListener("drop", handleDrop);

addPostForm.addEventListener("submit", validateForm);

function preventDefault(e) {
    e.preventDefault();
    e.stopPropagation();
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

function showLoader() {
    dropzone.classList.remove("d-flex");
    dropzone.classList.add("d-none");
    imagePreview.classList.add("d-none");
    loaderElm.classList.remove("d-none");
}

function hideLoader() {
    dropzone.classList.add("d-none");
    imagePreview.classList.remove("d-none");
    loaderElm.classList.add("d-none");
}

function resetInput() {
    imagePreview.classList.add("d-none");
    dropzone.classList.remove("d-none");
    dropzone.classList.add("d-flex");
    imagePreview.querySelector("img").src = "";
    imageElm.value = "";
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

function handleDragOver(e) {
    dropzone.classList.add("dragover");
}

function handleOut(e) {
    dropzone.classList.remove("dragover");
}

function handleDrop(e) {
    let droppedFiles = e.dataTransfer.files;

    if (droppedFiles.length >= 1) {
        if (!validateFile(droppedFiles[0])) return;

        const dT = new DataTransfer(),
            img = droppedFiles[0];

        dT.items.add(img);

        imageElm.files = dT.files;

        reverseStateOfElms();
        showImage();
    }
}

function handleUpload(e) {
    if (!validateFile(imageElm.files[0])) return;
    reverseStateOfElms();
    showImage();
}

function showImage() {
    if (imageElm.files && imageElm.files[0]) {
        showLoader();

        const reader = new FileReader();

        reader.addEventListener("load", e => {
            imagePreview.querySelector("img").src = e.target.result;
            hideLoader();
        });

        reader.readAsDataURL(imageElm.files[0]);
    }
}

function reverseStateOfElms() {
    if (dropzone.classList.contains("d-flex")) {
        dropzone.classList.remove("d-flex");
        dropzone.classList.add("d-none");
    } else {
        dropzone.classList.remove("d-none");
        dropzone.classList.add("d-flex");
    }

    if (imagePreview.classList.contains("d-none")) {
        imagePreview.classList.remove("d-none");
    } else {
        imagePreview.classList.add("d-none");
    }
}

function validateForm() {
    let imageErr = false,
        captionErr = false,
        captionErrMax = false;

    if (imageElm.files.length !== 1) {
        document.getElementById("image-err").style.display = "block";
        imageErr = true;
    } else {
        document.getElementById("image-err").style.display = "none";
        imageErr = false;
    }

    if (document.getElementById("caption").value == "") {
        document.getElementById("caption-err").style.display = "block";
        captionErr = true;
    } else {
        document.getElementById("caption-err").style.display = "none";
        captionErr = false;
    }

    if (document.getElementById("caption").value.length > 100) {
        document.getElementById("caption-err-max").style.display = "block";
        captionErrMax = true;
    } else {
        document.getElementById("caption-err-max").style.display = "none";
        captionErrMax = false;
    }

    if (!imageErr && !captionErr && !captionErrMax) {
        uploadBtn.disabled = true;
        uploadBtn.querySelector("div").classList.remove("d-none");
        uploadBtn.style.cursor = "no-drop";
        addPostForm.submit();
    }
}
