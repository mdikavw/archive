<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post)
        {
            $numComments = rand(1, 10);
            $firstLevelComments = Comment::factory($numComments)->create(['post_id' => $post->id]);

            foreach ($firstLevelComments as $comment)
            {
                $numReplies = rand(1, 10);
                Comment::factory($numReplies)->create(['parent_id' => $comment->id, 'post_id' => $comment->post_id]);
            }
        }
    }
}
