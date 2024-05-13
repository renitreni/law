<section class="py-2 px-4">
    <div x-data="{show:false}">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4>Files uploaded</h4>
            <button x-show="!show" x-on:click="show = true" class="btn btn-sm btn-primary">Upload new file</button>
        </div>
        <div  class="d-flex justify-content-end">
            <form  class="d-flex justify-content-between align-items-center gap-2" style="max-width: 500px"
                wire:submit='uploadNewFile' enctype="multipart/form-data">
                <input x-show="show" multiple wire:model='newFiles' class="form-control" type="file">
                <div  class="d-flex gap-1">
                    <button wire:loading.attr="disabled" wire:target='newFiles'  x-show="show" type="submit" class="btn btn-sm btn-outline-primary">
                        <span wire:loading.remove wire:target='newFiles'>Upload</span>
                        <span wire:loading wire:target='newFiles'>Uploading...</span>
                    </button>
                    <button x-show="show" type="button" x-on:click="show = false"
                        class="btn btn-sm btn-outline-secondary">Cancel</button>
                </div>
            </form>

        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Filename</th>
                <th scope="col">Uploaded By</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($files as $file )
            <tr wire:key='{{ $file['filename'] }}'>
                <td>{{ $file['filename'] }}</td>
                <td>{{ $file['uploaded_by'] }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" target="_blank"
                        href="{{ route('download_file',['file'=>$file['filename']]) }}">Download</a>
                    <button wire:confirm='Are you sure to delete {{ $file['filename'] }}' type="button"
                        wire:click='deleteFile({{ $file['id'] }})' class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12"> No files</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</section>
