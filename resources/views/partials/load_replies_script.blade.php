<script>
    $(document).ready(function() {
        var id = "{{ $comment->id }}"
        var type = "{{ get_class($comment) == 'App\\Models\\Post' ? 'post' : 'comment' }}"
        $(`#comment${id}LoadRepliesButton`).click(function(e) {
            e.preventDefault();

            if ($(`#comment${id}RepliesContainer`).children().length == 1) {
                getReplies(id);
            }
        });

        function getReplies(id) {
            $.ajax({
                type: "GET",
                url: `/comments/${id}/replies`,
                success: function(response) {
                    $(`#comment${id}RepliesContainer`).append(response.view);
                    response.scripts.forEach(script => {
                        $('body').append(script)
                    });
                }
            });
        }

        $(`#${type}${id}CommentForm`).submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize()

            makeComment(formData)
        });

        function makeComment(formData) {
            $.ajax({
                type: "POST",
                url: "/comment",
                data: formData,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(`#${type}${id}CommentForm`)[0].reset()
                    $(`#comment${id}RepliesContainer`).append(response.view);
                    $(`#post${id}NoComments`).hide()
                }
            });
        }
    });
</script>
