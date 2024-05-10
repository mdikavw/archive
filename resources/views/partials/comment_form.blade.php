@php
    $type = get_class($reactable) == 'App\Models\Post' ? 'post' : 'comment';
    $id = $reactable->id;
    $isHidden ??= true;
@endphp
<div id="{{ $type }}{{ $id }}commentFormContainer">
    <form class="comment-form" id="{{ $type }}{{ $id }}CommentForm" action="/comment" method="POST">
        @csrf
        <input class="input" name="content" type="text" placeholder="Add a Comment...">
        <input name="post_id" type="hidden" value="{{ $type == 'post' ? $reactable->id : $reactable->post->id }}">
        <input name="parent_id" type="hidden" value="{{ $type == 'post' ? null : $reactable->id }}">
        <button class="comment-form-btn">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let type = '{{ $type }}'
            let id = '{{ $id }}'
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
                        $(`#post${id}CommentsContainer`).append(response.view)
                        $(`#post${id}NoComments`).hide()
                    }
                });
            }
        });
    </script>
@endpush
