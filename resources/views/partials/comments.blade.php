@foreach($comments as $comment)
    <div class="comment c-{{$comment->getLevel()}}">
        <p>{{$comment->author->name}}: {{$comment->content}}</p>
        <div class="comment-actions">
            <a href="#" class="show-reply"><i class="icon ion-reply"></i> reply</a>
            <form method="post" action="/post-comment" class="replier hidden">
                {{ csrf_field() }}
                <input type="hidden" name="parent_id" value="{{$comment->id}}" />
                <textarea placeholder="type your reply here" name="content"></textarea>
                <button type="submit" class="button">Reply</button>
            </form>
        </div>
        @if($comment->children->count() > 0 && !$endLoop)
            @if($comment->getDepth() > 3)
                @include('partials.comments', ['comments' => $comment->descendants()->get(), 'endLoop' => true])
            @else
                @include('partials.comments', ['comments' => $comment->children()->get(), 'endLoop' => false])
            @endif
        @endif
    </div>
@endforeach