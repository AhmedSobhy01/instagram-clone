function addComment(e, postTo) {
    let form = e.target,
        postId = form.querySelector(".add-comment-field").id.split("-")[1],
        commentBody = form.querySelector(".add-comment-field").value,
        postComments = document.querySelector(".comments"),
        commentLoading = false;

    if (!commentLoading) {
        commentLoading = true;
        form.querySelector(".btn").style.display = "none";
        form.querySelector(".comment-loader").style.display = "inline-block";
        axios
            .post(this.commentUrl, {
                postID: postId,
                comment: commentBody
            })
            .then(res => res.data)
            .then(data => {
                if (data.response_code == 201) {
                    const a = data.data.comment,
                        b = `
                    <li class="py-2">
                        <div class="d-flex">
                            <div class="comment-author-image">
                                <img src="{{ $comment->user->profile_image }}" alt="User Image" class="rounded-circle mr-2" style="width: 35px;height: 35px;">
                            </div>
                            <div class="comment-content">
                                <span class="comment-author-username"><a href="">{{ $comment->user->username }}</a></span> <span class="comment-body">{{ $comment->body }} </span>
                                <div class="comment-info">
                                    <div class="comment-posted-at">1h</div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;

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
                form.querySelector(".comment-loader").style.display = "none";
                form.querySelector(".btn").style.display = "inline-block";
                this.commentLoading = false;
            });
    }
}
