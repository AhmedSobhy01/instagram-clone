<template>
    <div>
        <button
            class="btn ml-4 d-flex align-items-center btn-primary"
            @click="followUser"
            :disabled="loading"
            :aria-disabled="loading"
            :style="[loading ? { cursor: 'no-drop' } : '']"
        >
            <div
                class="loadingio-spinner-rolling-azt7iucozal mr-2"
                v-if="loading"
            >
                <div class="ldio-7lxobt9epcp">
                    <div></div>
                </div>
            </div>

            <span v-text="buttonText"></span>
        </button>
    </div>
</template>

<script>
export default {
    props: ["userId", "follows", "postTo"],

    watch: {
        status: function() {
            if (!this.loading) {
                this.buttonText = this.status ? "Unfollow" : "Follow";
            }
        },
        loading: function() {
            this.buttonText = this.loading
                ? "Loading"
                : this.status
                ? "Unfollow"
                : "Follow";
        }
    },

    data: function() {
        return {
            status: this.follows,
            buttonText: this.follows ? "Unfollow" : "Follow",
            loading: false
        };
    },

    methods: {
        followUser() {
            this.loading = true;
            axios
                .post(this.postTo, {
                    userID: this.userId
                })
                .then(response => response.data)
                .then(data => {
                    if (data.error_code == 201) {
                        this.status = !this.status;
                    }

                    if (this.status) {
                        document.getElementById("followers-count").innerHTML =
                            parseInt(
                                document.getElementById("followers-count")
                                    .innerHTML
                            ) + 1;
                    } else {
                        document.getElementById("followers-count").innerHTML =
                            parseInt(
                                document.getElementById("followers-count")
                                    .innerHTML
                            ) - 1;
                    }

                    this.loading = !this.loading;
                })
                .catch(err => {
                    if (err.response.status == 401) {
                        window.location = err.response.data.redirectUrl;
                    } else if (err.response.status == 404) {
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
                    } else {
                        toastr.error(
                            err.response.data.error_message ||
                                "There has been error. Please try again",
                            err.response.data.error_title || "Error",
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
                    this.loading = !this.loading;
                });
        }
    }
};
</script>
