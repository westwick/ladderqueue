@foreach($comments as $comment)
    <div class="comment c-{{$comment->getLevel()}}">
        <p>{{$comment->author->name}}: {{$comment->content}}</p>
        <div class="replier hidden">
            <form method="post" action="/post-comment">
                {{ csrf_field() }}
                <input type="hidden" name="parent_id" value="{{$comment->id}}" />
                <textarea placeholder="type your reply here" name="content"></textarea>
                <button type="submit" class="button">Reply</button>
            </form>
        </div>
        @if($comment->children->count() > 0)
            @include('partials.comments', ['comments' => $comment->children()->get()])
        @endif
    </div>
@endforeach