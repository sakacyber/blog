<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Handle the Post "created" event.
     *
     * @return void
     */
    public function created(Post $post)
    {
        $this->saveCategoryAndTag($post);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @return void
     */
    public function updated(Post $post)
    {
        $this->saveCategoryAndTag($post);
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }

    public function saveCategoryAndTag($post)
    {

        if ($this->request->has('category')) {
            $post->categories()->sync($this->request->category);
        }
    }
}
