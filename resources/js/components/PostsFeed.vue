<template>
    <div class="posts">
        <div class="post card mb-4" v-for="post in posts" :key="post.id">
            <div class="card-header post-user">
                <div class="d-flex align-items-center">
                    <a :href="post.user.profile_url">
                        <img
                            :src="post.user.profile_image"
                            alt="Profile Image"
                            style="width: 35px;height: 35px;"
                        />
                    </a>
                    <a
                        :href="post.user.profile_url"
                        class="post-author-username h6"
                        >{{ post.user.username }}</a
                    >
                </div>
            </div>
            <div class="card-body p-0">
                <div class="card-image d-flex">
                    <span class="image-skeleton w-100"></span>
                    <img
                        class="post-image w-100"
                        :src="post.image"
                        alt="Post"
                        @load="imageLoaded($event)"
                    />
                </div>
                <div class="post-footer py-3 px-4">
                    <div class="post-actions d-flex align-items-center">
                        <like-button
                            :post-id="post.id"
                            :post-to="likeUrl"
                            :likes="post.likedByCurrentUser"
                        ></like-button>
                        <div
                            class="ml-3"
                            style="cursor: pointer"
                            @click="redirectToPost(post.id)"
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
                    <div
                        class="post-likes mt-2"
                        style="cursor: pointer"
                        @click="redirectToPost(post.id)"
                    >
                        <span
                            :id="'likes-' + post.id"
                            v-text="post.likesCount"
                        ></span>
                        likes
                    </div>
                    <div class="post-caption mt-1">
                        <a
                            :href="post.user.profile_url"
                            class="post-caption-author"
                            v-text="post.user.username"
                        ></a>
                        <span style="word-break: break-all">{{
                            post.caption
                        }}</span>
                    </div>
                    <div class="post-comments mt-1">
                        <div
                            class="mb-1 view-all-comments"
                            v-if="post.commentsCount"
                            @click="redirectToPost(post.id)"
                        >
                            View all {{ post.commentsCount }} comments
                        </div>
                        <div class="post-comments-latest">
                            <div
                                class="d-flex mb-1 post-comment-latest"
                                v-for="comment in post.comments"
                                :key="comment.id"
                            >
                                <a
                                    :href="comment.user.profile_url"
                                    v-text="comment.user.username"
                                ></a>
                                <span>&nbsp;{{ comment.body }}</span>
                            </div>
                            <div class="time-posted">1 hour ago</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0 py-2">
                <form
                    class="d-flex align-items-center"
                    @submit.prevent="addComment($event, post)"
                >
                    <textarea
                        class="add-comment-field pl-3"
                        aria-label="Add a comment…"
                        placeholder="Add a comment…"
                        autocomplete="off"
                        autocorrect="off"
                        :id="'comment-' + post.id"
                    ></textarea>
                    <button
                        class="ml-auto px-4 py-0 btn"
                        :disabled="commentLoading"
                        :style="[commentLoading ? { cursor: 'no-drop' } : '']"
                    >
                        Post
                    </button>
                    <div
                        class="mx-auto loadingio-spinner-rolling-mufr14le4r comment-loader"
                        style="display: none"
                    >
                        <div class="ldio-va3amnnosd">
                            <div></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div
            class="h2 text-center m-0 py-3"
            v-if="end"
            v-html="endMessage"
        ></div>
        <div
            class="h2 text-center m-0 py-3 text-danger"
            v-if="this.error.status && !busy && !end"
        >
            {{ this.error.message }}
        </div>
        <div class="loader" v-if="busy && !end"></div>
    </div>
</template>

<script>
export default {
    props: [
        "feedUrl",
        "likeUrl",
        "commentUrl",
        "postUrl",
        "authId",
        "endMessage",
        "commentErrorRequired",
        "commentErrorMax",
        "errorWord"
    ],

    data: function() {
        return {
            posts: [],
            page: 1,
            busy: false,
            end: false,
            error: {
                status: false,
                message: ""
            },
            commentLoading: false
        };
    },

    methods: {
        getPosts() {
            if (!this.busy && !this.end) {
                this.busy = true;
                axios
                    .get(this.feedUrl, {
                        params: {
                            page: this.page
                        }
                    })
                    .then(res => res.data)
                    .then(data => {
                        this.page++;
                        this.posts.push(...data.data.data);
                        if (data.data.data.length == 0) {
                            this.end = true;
                        }
                    })
                    .catch(err => {
                        if (err.response.status == 401) {
                            window.location = err.response.data.redirectUrl;
                        } else {
                            this.error.status = true;
                            this.error.message =
                                err.response.data.error_message ||
                                "There has been an error. Please try again.";
                        }
                    })
                    .finally(() => {
                        this.busy = false;
                    });
            }
        },
        scroll() {
            window.addEventListener("scroll", e => {
                if (
                    window.innerHeight + window.scrollY >=
                    document.body.offsetHeight - 1000
                ) {
                    this.getPosts();
                }
            });
        },
        addComment(e, post) {
            let form = e.target,
                postId = form
                    .querySelector(".add-comment-field")
                    .id.split("-")[1],
                commentBody = form.querySelector(".add-comment-field").value;

            if (!this.commentLoading) {
                if (commentBody == "") {
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
                } else if (commentBody.length > 255) {
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

                this.commentLoading = true;
                form.querySelector(".btn").style.display = "none";
                form.querySelector(".comment-loader").style.display =
                    "inline-block";
                axios
                    .post(this.commentUrl, {
                        postID: postId,
                        comment: commentBody
                    })
                    .then(res => res.data)
                    .then(data => {
                        if (data.response_code == 201) {
                            post.comments.push(data.data.comment);
                            post.commentsCount += 1;
                        }
                        form.querySelector(".add-comment-field").value = "";
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
                        form.querySelector(".comment-loader").style.display =
                            "none";
                        form.querySelector(".btn").style.display =
                            "inline-block";
                        this.commentLoading = false;
                    });
            }
        },
        redirectToPost(postId) {
            window.location = this.postUrl.slice(0, -1) + postId;
        },
        imageLoaded(e) {
            e.target.parentElement.querySelector(
                ".image-skeleton"
            ).style.visibility = "hidden";
        }
    },

    mounted() {
        this.getPosts();
        this.scroll();
    }
};
</script>
