/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
Vue.prototype.$user = window.User;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("search-bar", require("./components/SearchBar.vue").default);

Vue.component("like-button", require("./components/LikeButton.vue").default);

Vue.component("posts-feed", require("./components/PostsFeed.vue").default);

Vue.component("post-right", require("./components/PostRight.vue").default);

Vue.component(
    "follow-button",
    require("./components/FollowButton.vue").default
);

Vue.component(
    "followers-modal",
    require("./components/FollowersModal.vue").default
);

Vue.component(
    "followings-modal",
    require("./components/FollowingsModal.vue").default
);

Vue.component("likes-modal", require("./components/LikesModal.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

// Helpers Functions
window.show_success = function(alert_title, alert_message, timeout = 10000) {
    toastr.success(alert_message, alert_title, {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        showDuration: 300,
        hideDuration: 1000,
        timeOut: timeout,
        extendedTimeOut: timeout,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    });
    return true;
};

window.show_error = function(alert_title, alert_message, timeout = 10000) {
    toastr.error(alert_message, alert_title, {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        showDuration: 300,
        hideDuration: 1000,
        timeOut: timeout,
        extendedTimeOut: timeout,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    });
    return true;
};
