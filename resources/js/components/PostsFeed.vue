<template>
    <div class="posts">
        <div class="post card mb-4" v-for="post in posts" :key="post.id">
            <div
                class="card-header post-user d-flex justify-content-between align-items-center"
            >
                <div class="d-flex align-items-center">
                    <a :href="post.user.profile_url">
                        <img
                            :src="post.user.profile_image"
                            class="rounded-circle"
                            alt="Profile Image"
                            style="width: 35px;height: 35px;"
                        />
                    </a>
                    <a
                        :href="post.user.profile_url"
                        class="post-author-username h6"
                    >
                        {{ post.user.username }}
                    </a>
                </div>
                <div v-if="$user.id == post.user.id">
                    <a
                        data-toggle="dropdown"
                        role="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="text-dark"
                        href="#"
                    >
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button
                            class="dropdown-item delete-post-btn"
                            :data-post-id="post.id"
                            @click="deletePost($event)"
                        >
                            {{ messages.words.delete }}
                        </button>
                    </div>
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
                            :urls="urls"
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
                        <span :id="'likes-' + post.id">
                            {{ post.likesCount.toLocaleString() }}
                        </span>
                        {{ messages.words.likes.toLowerCase() }}
                    </div>
                    <div class="post-caption mt-1">
                        <a
                            :href="post.user.profile_url"
                            class="post-caption-author"
                        >
                            {{ post.user.username }}
                        </a>
                        <span style="word-break: break-all">
                            {{ post.caption }}
                        </span>
                    </div>
                    <div class="post-comments mt-1">
                        <div
                            class="mb-1 view-all-comments"
                            v-if="post.commentsCount"
                            @click="redirectToPost(post.id)"
                        >
                            {{ messages.words.view_all }}
                            {{ post.commentsCount.toLocaleString() }}
                            {{ messages.words.comments.toLowerCase() }}
                        </div>
                        <div class="post-comments-latest">
                            <div
                                class="mb-1 post-comment-latest"
                                v-for="comment in post.comments"
                                :key="comment.id"
                            >
                                <a :href="comment.user.profile_url">
                                    {{ comment.user.username }}
                                </a>
                                <span style="word-break: break-all">
                                    {{ comment.body }}
                                </span>
                            </div>
                            <div class="time-posted">
                                {{
                                    timeAgo.format(
                                        new Date(post.created_at),
                                        "round"
                                    )
                                }}
                            </div>
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
                        {{ messages.words.post }}
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
            v-html="messages.end_of_page.title"
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
    props: ["urls", "messages"],

    data: function() {
        return {
            timeAgo: window.timeAgo,
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
            if (this.busy || this.end) return;
            this.busy = true;
            axios
                .get(this.urls.feed.index, {
                    params: {
                        page: this.page
                    }
                })
                .then(res => res.data)
                .then(data => {
                    this.page++;
                    this.posts.push(...data.data.data);
                    this.end = data.data.data.length == 0 ? true : false;
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
        },

        addComment(e, post) {
            if (this.commentLoading) return;

            const form = e.target,
                postId = form
                    .querySelector(".add-comment-field")
                    .id.split("-")[1],
                commentBody = form.querySelector(".add-comment-field").value;

            if (commentBody == "") {
                show_error(
                    this.messages.comment_errors.required.title,
                    this.messages.comment_errors.required.message
                );
                return false;
            } else if (commentBody.length > 255) {
                show_error(
                    this.messages.comment_errors.max.title,
                    this.messages.comment_errors.max.message
                );
                return false;
            }

            this.commentLoading = true;
            form.querySelector(".btn").style.display = "none";
            form.querySelector(".comment-loader").style.display =
                "inline-block";

            axios
                .post(this.urls.comment.store, {
                    postId: postId,
                    comment: commentBody
                })
                .then(res => res.data)
                .then(data => {
                    post.comments.push(data.data.comment);
                    post.commentsCount++;
                    form.querySelector(".add-comment-field").value = "";
                })
                .catch(err => {
                    if (err.response.status == 401) {
                        window.location = err.response.data.redirectUrl;
                    } else {
                        show_err(
                            err.response.data.error_title,
                            err.response.data.error_message
                        );
                    }
                })
                .finally(() => {
                    form.querySelector(".comment-loader").style.display =
                        "none";
                    form.querySelector(".btn").style.display = "inline-block";
                    this.commentLoading = false;
                });
        },

        redirectToPost(postId) {
            window.location = this.urls.post.index.slice(0, -1) + postId;
        },

        imageLoaded(e) {
            e.target.parentElement.querySelector(
                ".image-skeleton"
            ).style.visibility = "hidden";
        },

        deletePost(e) {
            const postId = parseInt(e.target.dataset.postId);

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
                                postId: postId
                            }
                        })
                        .then(res => res.data)
                        .then(data => {
                            Swal.close();

                            this.posts = this.posts.filter(
                                v => v.id !== postId
                            );

                            show_success(data.error_title, data.error_message);
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
            });
        }
    },

    mounted() {
        this.getPosts();

        window.addEventListener("scroll", e => {
            if (
                window.innerHeight + window.scrollY >=
                document.body.offsetHeight - 1000
            ) {
                this.getPosts();
            }
        });
    }
};
</script>
