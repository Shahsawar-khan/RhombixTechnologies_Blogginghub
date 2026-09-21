@extends('layouts.admin')
@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('content')
<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid grid-cols-3 gap-6">

        <div class="col-span-2 space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Post Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-indigo-500 outline-none text-lg font-medium" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Excerpt</label>
                <textarea name="excerpt" rows="3"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Content</label>
                <textarea name="content" id="content-editor" rows="15">{{ old('content', $post->content) }}</textarea>
                @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Publish</h3>
                <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg">
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>

                <button type="submit"
                        class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold">
                    Update Post
                </button>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Featured Image</h3>
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         class="w-full h-32 object-cover rounded-lg mb-3">
                @endif
                <input type="file" name="featured_image" accept="image/*"
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-semibold">
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Categories</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Tags</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    // Custom Upload Adapter
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
        }

        abort() {
            if (this.xhr) this.xhr.abort();
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin.posts.upload") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                resolve({
                    default: response.url
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#content-editor'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'uploadImage', 'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => console.log('CKEditor loaded successfully'))
            .catch(error => console.error('CKEditor error:', error));
    });
</script>
@endpush