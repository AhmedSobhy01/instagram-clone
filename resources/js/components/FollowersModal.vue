<template>
    <div
        class="modal fade bd-example-modal-sm show"
        id="followersModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="followersModal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">
                        {{ messages.words.followers }}
                    </h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div
                    class="modal-body py-1"
                    style="max-height: 300px;overflow-y: scroll;"
                    ref="followersModal"
                >
                    <div
                        class="h3 m-0 p-3 text-center"
                        v-if="followers.length == 0"
                    >
                        {{ messages.words.nothing_found }}
                    </div>
                    <div
                        class="follower py-2"
                        v-for="follower in followers"
                        :key="follower.id"
                    >
                        <a
                            :href="follower.profile_url"
                            class="text-decoration-none"
                        >
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <img
                                        :src="follower.profile_image"
                                        class="rounded-circle"
                                        alt="User Image"
                                        style="width: 35px; height: 35px;"
                                    />
                                </div>
                                <div class="text-dark">
                                    {{ follower.username }}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div
                        class="loadingio-spinner-rolling-dbisj67kqze d-block mx-auto my-2"
                        v-if="loading"
                    >
                        <div class="ldio-j0phwa9fshm"><div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["urls", "messages", "userId"],

    data: function() {
        return {
            followers: [],
            page: 1,
            loading: false,
            end: false
        };
    },

    methods: {
        getFollowers() {
            if (this.loading || this.end) return;

            this.loading = true;

            axios
                .post(
                    this.urls.followers.index,
                    {
                        userID: this.userId
                    },
                    {
                        params: {
                            page: this.page
                        }
                    }
                )
                .then(res => res.data)
                .then(data => {
                    this.followers.push(...data.data.followers);
                    this.page++;
                    this.end = data.data.last_page ? true : false;
                })
                .catch(err => {
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
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },

    mounted() {
        this.getFollowers();

        // Enable Lazy Loading (Scroll Load)
        const elm = this.$refs.followersModal;
        elm.addEventListener("scroll", e => {
            if (elm.offsetHeight + elm.scrollTop >= elm.scrollHeight - 100) {
                this.getFollowers();
            }
        });
    }
};
</script>
