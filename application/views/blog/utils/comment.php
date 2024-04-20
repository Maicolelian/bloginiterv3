<?php header("Content-Type: application/javascript"); ?>
window.onload = function () {
    $(function () {
        var saveComment = function (data) {

            $.ajax({
                url: "<?php echo base_url() ?>comment/add",
                method: "POST",
                data: {comment: data.content, parent_id: data.parent, post_id:POSTID}
            }).done(function (data) {

            });

            return data;
        };

        var avatar = '<?php echo $this->session->userdata('avatar'); ?>';
        var user_id = <?php echo ($this->session->userdata('id') == null) ? 0 : $this->session->userdata('id'); ?>;
        var comment = <?php echo ($this->session->userdata('id') == null) ? true : 0; ?>;
                $('#comments-container').comments({

            profilePictureURL: avatar,
            currentUserId: user_id,
            enableReplying: user_id,
            readOnly: comment,
            currentUserIsAdmin: false,
            enableHashtags: false,
            roundProfilePictures: true,
            textareaRows: 1,
            enableAttachments: false,
            enablePinging: false,
            enableUpvoting: false,
            enableEditing: false,
            enableDeleting: false,
            getComments: function (success, error) {
                $.ajax({
                    url: "<?php echo base_url() ?>comment/json/"+POSTID,
                                            method: "GET",
                                        }).done(function (data) {

                                            commentsArray2 = jQuery.parseJSON(data);
                                            success(commentsArray2);
                                        });
                                    },
                                    postComment: function (data, success, error) {
                                        setTimeout(function () {
                                            success(saveComment(data));
                                        }, 500);
                                    },
                                    putComment: function (data, success, error) {
                                        setTimeout(function () {
                                            success(saveComment(data));
                                        }, 500);
                                    },
                                    deleteComment: function (data, success, error) {
                                        setTimeout(function () {
                                            success();
                                        }, 500);
                                    }
                                });
                            });
                        };