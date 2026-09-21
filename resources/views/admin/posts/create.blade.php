@extends('layouts.admin')
@section('title', 'Create Post')
@section('page-title', 'Create New Post')

@section('content')
<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-3 gap-6">

        {{-- LEFT: Main Content --}}
        <div class="col-span-2 space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Post Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none text-lg font-medium"
                       placeholder="Enter post title..." required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Excerpt (Short Description)</label>
                <textarea name="excerpt" rows="3"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-indigo-500 outline-none"
                          placeholder="Brief summary...">{{ old('excerpt') }}</textarea>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Content</label>
                <textarea name="content" id="content-editor" rows="15"
                          class="w-full border border-slate-300 rounded-lg">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="space-y-6">

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Publish</h3>
                <label class="block text-sm font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>

                <button type="submit"
                        class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-semibold">
                    Save Post
                </button>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Featured Image</h3>
                <input type="file" name="featured_image" accept="image/*"
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-semibold hover:file:bg-indigo-100">
                @error('featured_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Categories</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </label>
                    @endforeach
                    @if($categories->isEmpty())
                        <p class="text-sm text-slate-400">No categories. <a href="{{ route('admin.categories.create') }}" class="text-indigo-600">Create one</a></p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Tags</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                    @if($tags->isEmpty())
                        <p class="text-sm text-slate-400">No tags. <a href="{{ route('admin.tags.create') }}" class="text-indigo-600">Create one</a></p>
                    @endif
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