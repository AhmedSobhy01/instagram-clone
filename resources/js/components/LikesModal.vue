<template>
    <div
        class="modal fade bd-example-modal-sm"
        id="likesModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="likesModal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">
                        {{ messages.words.likes }}
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
                    style="max-height: 300px; overflow-y: scroll"
                    ref="likesModal"
                >
                    <div
                        class="h3 m-0 p-3 text-center"
                        v-if="likes.length == 0 && end"
                    >
                        {{ messages.words.nothing_found }}
                    </div>
                    <div class="like py-2" v-for="like in likes" :key="like.id">
                        <a
                            :href="like.user.profile_url"
                            class="text-decoration-none"
                        >
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <img
                                        :src="like.user.profile_image"
                                        class="rounded-circle"
                                        alt="User Image"
                                        style="width: 35px; height: 35px"
                                    />
                                </div>
                                <div>{{ like.user.username }}</div>
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
    props: ["urls", "messages", "postId"],

    data: function () {
        return {
            likes: [],
            page: 1,
            loading: false,
            end: false,
        };
    },

    methods: {
        getLikes(reset) {
            if (this.loading || (this.end && !reset)) return;

            if (reset) {
                this.likes = [];
                this.page = 1;
                this.end = false;
            }

            this.loading = true;

            axios
                .post(
                    this.urls.like.index,
                    {
                        postId: this.postId,
                    },
                    {
                        params: {
                            page: this.page,
                        },
                    }
                )
                .then((res) => res.data)
                .then((data) => {
                    this.likes.push(...data.data.data);
                    this.page++;
                    this.end =
                        data.data.current_page >= data.data.last_page
                            ? true
                            : false;
                })
                .catch((err) => {
                    show_error(
                        err.response.data.error_title,
                        err.response.data.error_message
                    );
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },

    mounted() {
        this.getLikes();

        this.observer = new MutationObserver((mutations) => {
            for (const m of mutations) {
                this.$nextTick(() => {
                    if (m.target.classList.contains("show"))
                        this.getLikes(true);
                });
            }
        });

        this.observer.observe(document.getElementById("likesModal"), {
            attributes: true,
            attributeOldValue: true,
            attributeFilter: ["class"],
        });

        // Enable Lazy Loading (Scroll Load)
        const elm = this.$refs.likesModal;
        elm.addEventListener("scroll", (e) => {
            if (elm.offsetHeight + elm.scrollTop >= elm.scrollHeight - 100) {
                this.getLikes();
            }
        });
    },

    beforeDestroy() {
        this.observer.disconnect();
    },
};
</script>
