<?php

use Livewire\Component;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

new class extends Component
{
    //

    public $post;
    public $title;
    public $content;
    public $tags;
    public $selectedTags = [];
    protected $rules = [
        'title' => 'required|min:5',
        'content' => 'required|min:10',
        'selectedTags' => 'array',
    ];
    public function mount($post = null)
    {
        if ($post) {
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
            $this->selectedTags = $post->tags->pluck('id')->toArray();
        }
    }
    public function save()
    {
        $this->validate();
        $isNew = !$this->post;
        if ($isNew) {
            $this->post = new Post();
            $this->post->user_id = auth()->id();
        }
        $this->post->title = $this->title;
        $this->post->slug = Str::slug($this->title);
        $this->post->content = $this->content;
        $this->post->is_published = true;
        $this->post->published_at = now();
        $this->post->save();
        $this->post->tags()->sync($this->selectedTags);
        session()->flash('message', $isNew ? 'Post created successfully.' : 'Post updated successfully.');
        return redirect()->route('posts.show', $this->post);
    }
    public function render()
    {
        $allTags = Tag::all();
        return view('livewire.⚡post-form', [
            'allTags' => $allTags,
        ]);
    }
};
?>

<div>
    {{-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius --}}

    <div>
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="title" class="text-gray-700 mb-2 block font-bold">Title</label>
                <input
                    wire:model="title"
                    type="text"
                    id="title"
                    class="text-gray-700 w-full rounded-lg border px-3 py-2 focus:outline-none"
                    required
                />
                @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="text-gray-700 mb-2 block font-bold">Content</label>
                <textarea
                    wire:model="content"
                    id="content"
                    rows="6"
                    class="text-gray-700 w-full rounded-lg border px-3 py-2 focus:outline-none"
                    required
                ></textarea>
                @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="text-gray-700 mb-2 block font-bold">Tags</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($allTags as $tag)
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                wire:model="selectedTags"
                                value="{{ $tag->id }}"
                                class="form-checkbox text-blue-600 h-5 w-5"
                            />
                            <span class="text-gray-700 ml-2">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 rounded px-4 py-2 font-bold text-white"
                >
                    {{ $post ? 'Update Post' : 'Create Post' }}
                </button>
            </div>
        </form>
    </div>

</div>
