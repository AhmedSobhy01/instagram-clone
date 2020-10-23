<template>
    <div class="right col-md-4 d-flex flex-column">
        <div
            class="post-author d-flex justify-content-between align-items-center"
            v-if="!mobile"
        >
            <div>
                <a :href="post.user.profile_url">
                    <img
                        :src="post.user.profile_image"
                        alt="Profile Image"
                        class="rounded-circle"
                        style="width: 35px;height: 35px;"
                    />
                </a>
                <a
                    :href="post.user.profile_url"
                    class="post-author-username h6 m-0 ml-2"
                >
                    {{ post.user.username }}
                </a>
            </div>
            <div class="p-2">
                <div v-if="$user.id == post.user.id">
                    <a
                        data-toggle="dropdown"
                        role="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="text-dark"
                        href="#"
                        style="transform: rotate(90deg); display: block;"
                    >
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button
                            class="dropdown-item delete-post-btn"
                            @click="deletePost($event)"
                        >
                            {{ messages.words.delete }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="post-comments py-2" v-if="!mobile">
            <ul class="m-0 p-0">
                <li class="py-2 mb-4">
                    <div class="d-flex">
                        <div class="comment-author-image">
                            <img
                                :src="post.user.profile_image"
                                alt="User Image"
                                class="rounded-circle mr-2"
                                style="width: 35px;height: 35px;"
                            />
                        </div>
                        <div class="comment-content">
                            <span class="comment-author-username">
                                <a :href="post.user.profile_url">
                                    {{ post.user.username }}
                                </a>
                            </span>
                            <span class="comment-body">
                                {{ post.caption }}
                            </span>
                            <div class="comment-info">
                                <div class="comment-posted-at">
                                    {{
                                        timeAgo.format(
                                            new Date(post.created_at),
                                            "mini-now"
                                        )
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <div
                    class="loadingio-spinner-rolling-zorg03qagl mx-auto mb-3 d-block"
                    v-if="comments.loading || comments.firstCommentsLoad"
                >
                    <div class="ldio-ztkrgk44qa">
                        <div></div>
                    </div>
                </div>

                <div
                    class="load-comments rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3"
                    v-if="
                        !comments.end &&
                            !comments.loading &&
                            !comments.firstCommentsLoad
                    "
                    @click="loadComments"
                >
                    <span
                        aria-label="Load more comments"
                        class="fas fa-plus"
                    ></span>
                </div>

                <div class="comments">
                    <li
                        class="py-2 position-relative"
                        v-for="comment in comments.data"
                        :key="comment.id"
                    >
                        <div class="d-flex">
                            <div class="comment-author-image">
                                <img
                                    :src="comment.user.profile_image"
                                    alt="User Image"
                                    class="rounded-circle mr-2"
                                    style="width: 35px;height: 35px;"
                                />
                            </div>
                            <div class="comment-content pr-3">
                                <span class="comment-author-username">
                                    <a
                                        :href="comment.user.profile_url"
                                        class="d-inline"
                                    >
                                        {{ comment.user.username }}
                                    </a>
                                </span>
                                <span class="comment-body">
                                    {{ comment.body }}
                                </span>
                                <div class="comment-info">
                                    <div class="comment-posted-at">
                                        {{
                                            timeAgo.format(
                                                new Date(comment.created_at),
                                                "mini-now"
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </div>
            </ul>
        </div>
        <div class="post-actions px-3 py-3" v-if="!mobile">
            <div class="d-flex align-items-center mt-2">
                <like-button
                    :post-id="post.id"
                    :urls="urls"
                    :likes="post.likedByCurrentUser"
                ></like-button>
                <div
                    class="ml-3"
                    style="cursor: pointer"
                    @click="focusAddComment"
                >
                    <svg
                        aria-label="Comment"
                        fill="#262626"
                        height="24"
                        viewBox="0 0 48 48"
                        width="24"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </div>
            </div>
            <div class="post-likes mt-2" style="cursor: pointer">
                <span :id="'likes-' + post.id">{{
                    post.likesCount.toLocaleString()
                }}</span>
                <span>{{ messages.words.likes.toLowerCase() }}</span>
            </div>
            <div class="post-time mt-2">
                {{ timeAgo.format(new Date(post.created_at), "round") }}
            </div>
        </div>
        <div class="post-actions py-3" v-if="mobile">
            <div class="d-flex align-items-center mt-2">
                <like-button
                    :post-id="post.id"
                    :urls="urls"
                    :likes="post.likedByCurrentUser"
                ></like-button>
                <div
                    class="ml-3"
                    style="cursor: pointer"
                    @click="focusAddComment"
                >
                    <svg
                        aria-label="Comment"
                        fill="#262626"
                        height="24"
                        viewBox="0 0 48 48"
                        width="24"
                    >
                        <path
                            clip-rule="evenodd"
                            d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </div>
                <div class="p-2 ml-auto">
                    <div v-if="$user.id == post.user.id">
                        <a
                            data-toggle="dropdown"
                            role="button"
                            aria-haspopup="true"
                            aria-expanded="false"
                            class="text-dark"
                            href="#"
                            style="transform: rotate(90deg); display: block;"
                        >
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button
                                class="dropdown-item delete-post-btn"
                                @click="deletePost($event)"
                            >
                                {{ messages.words.delete }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-likes mt-2" style="cursor: pointer">
                <span :id="'likes-' + post.id">{{
                    post.likesCount.toLocaleString()
                }}</span>
                <span>{{ messages.words.likes.toLowerCase() }}</span>
            </div>
            <div>
                <a class="post-author" :href="post.user.profile_url">
                    {{ post.user.username }}
                </a>
                <span>{{ post.caption }}</span>
            </div>
            <div class="post-time mt-2">
                {{ timeAgo.format(new Date(post.created_at), "round") }}
            </div>
        </div>
        <div class="post-comments py-2" v-if="mobile">
            <ul class="m-0 p-0">
                <div
                    class="loadingio-spinner-rolling-zorg03qagl mx-auto mb-3 d-block"
                    v-if="comments.loading || comments.firstCommentsLoad"
                >
                    <div class="ldio-ztkrgk44qa">
                        <div></div>
                    </div>
                </div>

                <div
                    class="load-comments rounded-circle d-flex justify-content-center align-items-center mx-auto my-3"
                    v-if="
                        !comments.end &&
                            !comments.loading &&
                            !comments.firstCommentsLoad
                    "
                    @click="loadComments"
                >
                    <span
                        aria-label="Load more comments"
                        class="fas fa-plus"
                    ></span>
                </div>

                <div class="h4 m-0 p-3 text-center">
                    {{ messages.no_comments }}
                </div>

                <div class="comments">
                    <li
                        class="py-2"
                        v-for="comment in comments.data"
                        :key="comment.id"
                    >
                        <div class="d-flex">
                            <div class="comment-author-image">
                                <img
                                    :src="comment.user.profile_image"
                                    alt="User Image"
                                    class="rounded-circle mr-2"
                                    style="width: 35px;height: 35px;"
                                />
                            </div>
                            <div class="comment-content">
                                <span class="comment-author-username">
                                    <a :href="comment.user.profile_url">
                                        {{ comment.user.username }}
                                    </a>
                                </span>
                                <span class="comment-body">
                                    {{ comment.body }}
                                </span>
                                <div class="comment-info">
                                    <div class="comment-posted-at">
                                        {{
                                            timeAgo.format(
                                                new Date(comment.created_at),
                                                "mini-now"
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </div>
            </ul>
        </div>
        <div class="add-comment p-0 d-flex align-items-center">
            <form
                class="d-flex align-items-center w-100"
                @submit.prevent="addComment"
            >
                <textarea
                    class="add-comment-field pl-3"
                    aria-label="Add a comment…"
                    placeholder="Add a comment…"
                    autocomplete="off"
                    autocorrect="off"
                    :id="'comment-' + post.id"
                    v-model="comments.addCommentVal"
                    ref="addCommentField"
                ></textarea>
                <button
                    class="ml-auto px-4 py-0 btn"
                    v-if="!comments.addingComment"
                >
                    {{ messages.words.post }}
                </button>
                <div
                    class="mx-auto loadingio-spinner-rolling-mufr14le4r comment-loader"
                    v-if="comments.addingComment"
                >
                    <div class="ldio-va3amnnosd">
                        <div></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ["postData", "urls", "messages"],

    watch: {
        "likes.loading": function() {
            let elm = document.querySelector("#likesModal .modal-body");
            if (this.likes.loading) {
                elm.innerHTML += `<div class="loadingio-spinner-rolling-dbisj67kqze d-block mx-auto my-2"><div class="ldio-j0phwa9fshm"><div></div></div></div>`;
            } else {
                elm.querySelector(
                    ".loadingio-spinner-rolling-dbisj67kqze"
                ).remove();
            }
        }
    },

    data: function() {
        return {
            timeAgo: window.timeAgo,
            post: this.postData,
            mobile: false,

            likes: {
                page: 1,
                loading: false,
                end: false
            },

            comments: {
                data: [],
                page: 1,
                loading: false,
                end: false,
                addCommentVal: "",
                firstCommentsLoad: false,
                addingComment: false
            }
        };
    },

    methods: {
        loadComments() {
            if (this.comments.loading) return;
            this.comments.loading = true;

            axios
                .get(this.urls.comment.index, {
                    params: {
                        postId: this.post.id,
                        page: this.comments.page
                    }
                })
                .then(res => res.data)
                .then(data => {
                    if (data.response_code == 200) {
                        this.comments.end =
                            data.data.current_page >= data.data.last_page;
                        this.comments.data.unshift(...data.data.data);
                        this.comments.page++;
                    }
                })
                .catch(err => {
                    show_error(
                        err.response.data.error_title,
                        err.response.data.error_message
                    );
                })
                .finally(() => {
                    this.comments.loading = false;
                    this.comments.firstCommentsLoad = false;
                });
        },

        addComment() {
            if (!this.comments.addingComment) {
                if (this.comments.addCommentVal == "") {
                    show_error(
                        this.messages.comment_errors.required.title,
                        this.messages.comment_errors.required.message
                    );
                    return false;
                } else if (this.comments.addCommentVal.length > 255) {
                    show_error(
                        this.messages.comment_errors.max.title,
                        this.messages.comment_errors.max.message
                    );
                    return false;
                }
                this.comments.addingComment = true;
                axios
                    .post(this.urls.comment.store, {
                        postId: this.post.id,
                        comment: this.comments.addCommentVal
                    })
                    .then(res => res.data)
                    .then(data => {
                        if (data.response_code == 201) {
                            this.comments.data.unshift(data.data.comment);
                            this.post.commentsCount++;
                        }
                        this.comments.addCommentVal = "";
                    })
                    .catch(err => {
                        if (err.response.status == 401) {
                            window.location = err.response.data.redirectUrl;
                        } else {
                            show_error(
                                err.response.data.error_title,
                                err.response.data.error_message
                            );
                        }
                    })
                    .finally(() => {
                        this.comments.addingComment = false;
                    });
            }
        },

        deletePost(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                showLoaderOnConfirm: true,
                preConfirm: del => {
                    return axios
                        .delete(this.urls.post.delete, {
                            data: {
                                postId: this.post.id
                            }
                        })
                        .then(res => res.data)
                        .then(data => {
                            return data;
                        })
                        .catch(err => {
                            Swal.close();
                            show_error(
                                err.response.data.error_title,
                                err.response.data.error_message
                            );
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(r => {
                if (r.isConfirmed) {
                    Swal.fire(
                        r.value.error_title,
                        r.value.error_message,
                        "success"
                    ).then(() => (window.location.href = this.urls.home.index));
                }
            });
        },

        focusAddComment() {
            this.$refs.addCommentField.focus();
        },

        checkScreen() {
            if (window.matchMedia("screen and (max-width: 768px)").matches) {
                this.mobile = true;
            } else {
                this.mobile = false;
            }
        }
    },

    mounted() {
        this.loadComments();
        this.checkScreen();
        window.addEventListener("resize", this.checkScreen);
    }
};
</script>
