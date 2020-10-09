<template>
    <div class="posts">
        <div class="post card mb-4" v-for="post in posts" :key="post.id">
            <div class="card-header post-user">
                <div class="d-flex align-items-center">
                    <a :href="post.user.url">
                        <img
                            :src="post.user.profile_image"
                            alt="Profile Image"
                            style="width: 35px;heigh: 35px;"
                        />
                    </a>
                    <a :href="post.user.url" class="post-author-username h6">{{
                        post.user.username
                    }}</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="card-image">
                    <img class="w-100" :src="post.image" alt="Post" />
                </div>
                <div class="post-footer py-3 px-4">
                    <div class="post-actions d-flex align-items-center">
                        <like-button
                            :post-id="post.id"
                            :post-to="likeUrl"
                            :likes="post.likes.map(x => x.user.id)"
                            :auth-id="authId"
                        ></like-button>
                        <div class="ml-3" style="cursor: pointer">
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
                            post.likes.length
                        }}</span>
                        likes
                    </div>
                    <div class="post-caption mt-2">
                        <span class="post-caption-author mr-1">
                            {{ post.user.username }}
                        </span>
                        {{ post.caption }}
                    </div>
                    <div class="post-comments mt-1">
                        <div class="mb-1" v-if="post.comments.length > 0">
                            View all {{ post.comments.length }} comments
                        </div>
                        <div class="post-comments-latest">
                            <div
                                class="d-flex align-items-center mb-1"
                                v-for="comment in post.comments"
                                :key="comment.id"
                            >
                                <div class="comment-autor">
                                    <a href="#">{{ comment.user.username }}</a>
                                </div>
                                <div class="comment-body ml-1">
                                    {{ comment.body }}
                                </div>
                            </div>
                            <div class="time-posted">1 hour ago</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0 py-2">
                <form action="" class="d-flex align-items-center">
                    <textarea
                        class="add-comment-field pl-3"
                        aria-label="Add a comment…"
                        placeholder="Add a comment…"
                        autocomplete="off"
                        autocorrect="off"
                    ></textarea>
                    <button class="ml-auto px-4 btn">Post</button>
                </form>
            </div>
        </div>
        <div class="h2 text-center m-0 py-3" v-if="end">
            Looks like the end. &#128549;<br />Follow more people for more
            posts.
        </div>
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
    props: ["feedUrl", "likeUrl", "commentUrl", "loginUrl", "authId"],

    data: function() {
        return {
            posts: [],
            page: 1,
            busy: false,
            end: false,
            error: {
                status: false,
                message: ""
            }
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
                        this.posts.push(...data.data);
                        if (data.data.length == 0) {
                            this.end = true;
                        }
                    })
                    .catch(err => {
                        if (err.response.status == 401) {
                            window.location = this.loginUrl;
                        } else {
                            this.error.status = true;
                            this.error.message =
                                err.response.data.message ||
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
        }
    },

    mounted() {
        this.getPosts();
        this.scroll();
    }
};
</script>
