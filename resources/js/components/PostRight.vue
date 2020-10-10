<template>
    <div class="right col-md-4 d-flex flex-column">
        <div class="post-author d-flex align-items-center" v-if="!mobile">
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
                v-text="post.user.username"
            ></a>
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
                                <a
                                    :href="post.user.profile_url"
                                    v-text="post.user.username"
                                ></a>
                            </span>
                            <span class="comment-body" v-text="post.caption">
                            </span>
                            <div class="comment-info">
                                <div class="comment-posted-at">1h</div>
                            </div>
                        </div>
                    </div>
                </li>

                <div
                    class="loadingio-spinner-rolling-zorg03qagl mx-auto mb-3 d-block"
                    v-if="commentsLoading || firstCommentsLoad"
                >
                    <div class="ldio-ztkrgk44qa">
                        <div></div>
                    </div>
                </div>

                <div
                    class="load-comments rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3"
                    v-if="
                        !commentsEnd && !commentsLoading && !firstCommentsLoad
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
                        class="py-2"
                        v-for="comment in comments"
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
                                    <a
                                        :href="comment.user.profile_url"
                                        v-text="comment.user.username"
                                    ></a>
                                </span>
                                <span
                                    class="comment-body"
                                    v-text="comment.body"
                                >
                                </span>
                                <div class="comment-info">
                                    <div class="comment-posted-at">1h</div>
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
                    :post-to="likeUrl"
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
                <span :id="'likes-' + post.id" v-text="post.likesCount"></span>
                <span> likes</span>
            </div>
            <div class="post-time mt-2">
                1 hour ago
            </div>
        </div>
        <div class="post-actions py-3" v-if="mobile">
            <div class="d-flex align-items-center mt-2">
                <like-button
                    :post-id="post.id"
                    :post-to="likeUrl"
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
                <span :id="'likes-' + post.id" v-text="post.likesCount"></span>
                <span> likes</span>
            </div>
            <div>
                <span class="post-author" v-text="post.user.username"></span
                >&nbsp;<span v-text="post.caption"></span>
            </div>
            <div class="post-time mt-2">
                1 hour ago
            </div>
        </div>
        <div class="post-comments py-2" v-if="mobile">
            <ul class="m-0 p-0">
                <div
                    class="loadingio-spinner-rolling-zorg03qagl mx-auto mb-3 d-block"
                    v-if="commentsLoading || firstCommentsLoad"
                >
                    <div class="ldio-ztkrgk44qa">
                        <div></div>
                    </div>
                </div>

                <div
                    class="load-comments rounded-circle d-flex justify-content-center align-items-center mx-auto my-3"
                    v-if="
                        !commentsEnd && !commentsLoading && !firstCommentsLoad
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
                        class="py-2"
                        v-for="comment in comments"
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
                                    <a
                                        :href="comment.user.profile_url"
                                        v-text="comment.user.username"
                                    ></a>
                                </span>
                                <span
                                    class="comment-body"
                                    v-text="comment.body"
                                >
                                </span>
                                <div class="comment-info">
                                    <div class="comment-posted-at">1h</div>
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
                    v-model="addCommentVal"
                    ref="addCommentField"
                ></textarea>
                <button class="ml-auto px-4 py-0 btn" v-if="!commentAdding">
                    Post
                </button>
                <div
                    class="mx-auto loadingio-spinner-rolling-mufr14le4r comment-loader"
                    v-if="commentAdding"
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
    props: [
        "postData",
        "likeUrl",
        "commentsGetUrl",
        "commentCreateUrl",
        "commentErrorRequired",
        "commentErrorMax",
        "errorWord"
    ],

    data: function() {
        return {
            post: this.postData,
            comments: [],
            commentPage: 1,
            addCommentVal: "",
            firstCommentsLoad: false,
            commentsLoading: false,
            commentAdding: false,
            commentsEnd: false,
            mobile: false
        };
    },

    methods: {
        loadComments() {
            if (!this.commentsLoading) {
                this.commentsLoading = true;

                let params = new URLSearchParams({
                    postId: this.post.id,
                    page: this.commentPage
                }).toString();

                axios
                    .get(this.commentsGetUrl, {
                        params: {
                            postId: this.post.id,
                            page: this.commentPage
                        }
                    })
                    .then(res => res.data)
                    .then(data => {
                        if (data.response_code == 200) {
                            console.log(data.data.data);
                            this.commentsEnd =
                                data.data.data.length < 1 ? true : false;
                            this.comments.unshift(...data.data.data);
                            this.commentPage++;
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
                    })
                    .finally(() => {
                        this.commentsLoading = false;
                        this.firstCommentsLoad = false;
                    });
            }
        },

        addComment() {
            if (!this.commentAdding) {
                if (this.addCommentVal == "") {
                    toastr.error(this.commentErrorRequired, this.errorWord, {
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
                    return false;
                } else if (this.addCommentVal.length > 255) {
                    toastr.error(this.commentErrorMax, this.errorWord, {
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
                    return false;
                }
                this.commentAdding = true;
                axios
                    .post(this.commentCreateUrl, {
                        postID: this.post.id,
                        comment: this.addCommentVal
                    })
                    .then(res => res.data)
                    .then(data => {
                        if (data.response_code == 201) {
                            console.log(data.data.comment);
                            this.comments.unshift(data.data.comment);
                            this.post.commentsCount++;
                        }
                        this.addCommentVal = "";
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
                    })
                    .finally(() => {
                        this.commentAdding = false;
                    });
            }
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
