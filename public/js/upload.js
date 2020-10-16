/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/upload.js":
/*!********************************!*\
  !*** ./resources/js/upload.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.getElementById("add-post-btn").addEventListener("click", function () {
  return $("#addPostModal").modal("show");
});
var imageElm = document.getElementById("image"),
    dropzone = document.getElementById("dropzone"),
    imagePreview = document.getElementById("image-preview"),
    loaderElm = document.getElementById("post-upload-loader"),
    resetBtn = document.getElementById("reset-btn"),
    addPostForm = document.getElementById("addPostForm"),
    uploadBtn = document.getElementById("uploadBtn");
var maxImageSize = 4,
    // In MB
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
    showErr("Maximum image size is ".concat(maxImageSize, " MB."));
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
  var droppedFiles = e.dataTransfer.files;

  if (droppedFiles.length >= 1) {
    if (!validateFile(droppedFiles[0])) return;
    var dT = new DataTransfer(),
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
    var reader = new FileReader();
    reader.addEventListener("load", function (e) {
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
  var imageErr = false,
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

/***/ }),

/***/ 2:
/*!**************************************!*\
  !*** multi ./resources/js/upload.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\instagram-clone\resources\js\upload.js */"./resources/js/upload.js");


/***/ })

/******/ });