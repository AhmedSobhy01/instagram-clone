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

/***/ "./resources/js/profile.js":
/*!*********************************!*\
  !*** ./resources/js/profile.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var profileImgForm = document.getElementById("profile-image-form"),
    profileImgFileElm = document.getElementById("profile-image-file"),
    changeProfileImageModal = $("#profileImageModal"),
    imagePreview = document.getElementById("image-preview"),
    uploadBtn = document.getElementById("upload");
var cropper, reader;
var maxImageSize = 10,
    // In MB
allowedExtensions = ["image/png", "image/jpeg"];
profileImgFileElm.accept = allowedExtensions.join(",");
profileImgFileElm.multiple = false;
profileImgFileElm.addEventListener("change", function (e) {
  e.preventDefault();
  e.stopPropagation();

  if (e.target.files && e.target.files.length > 0) {
    var img = e.target.files[0];
    if (!validateFile(img)) return;
    loaderStatus(true);
    reader = new FileReader();
    reader.addEventListener("load", function (e) {
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
changeProfileImageModal.on("hidden.bs.modal", function () {
  cropper.destroy();
  cropper = null;
  profileImgFileElm.value = "";
  imagePreview.src = "";
  imagePreview.parentElement.querySelectorAll("div").forEach(function (div) {
    return div.remove();
  });
  uploadStatus(false);
  document.querySelector(".preview").innerHTML = "";
});
uploadBtn.addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  uploadStatus(true);
  canvas = cropper.getCroppedCanvas({
    width: 500,
    height: 500
  });
  canvas.toBlob(function (blob) {
    url = URL.createObjectURL(blob);
    reader.readAsDataURL(blob);
    reader.addEventListener("load", function () {
      var base64data = reader.result;
      axios.patch(profileImgForm.action, {
        _token: $('meta[name="_token"]').attr("content"),
        image: base64data
      }).then(function (res) {
        return res.data;
      }).then(function (data) {
        if (data.response_code == 200) {
          document.querySelector("#profile-image-form img").src = base64data;
          changeProfileImageModal.modal("hide");
          toastr.success(data.error_message, data.error_title);
        }
      })["catch"](function (err) {
        if (err.response.status == 401) {
          window.location = err.response.data.redirectUrl;
        } else {
          toastr.error(err.response.data.error_message, err.response.data.error_title, {
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
          });
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
    showErr("Maximum image size is ".concat(maxImageSize, " MB."));
    return false;
  }

  return true;
}

/***/ }),

/***/ 2:
/*!***************************************!*\
  !*** multi ./resources/js/profile.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\instagram-clone\resources\js\profile.js */"./resources/js/profile.js");


/***/ })

/******/ });