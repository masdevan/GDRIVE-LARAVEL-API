<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File to Google Drive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload File to Google Drive</h2>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <div class="container mt-5 card">
        <h3>Create New Folder</h3>
        <div class=" mt-3">
        <form action="{{ route('google-drive.create-folder') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="folder_name" class="form-label">Folder Name</label>
                <input type="text" class="form-control" id="folder_name" name="folder_name" placeholder="Enter folder name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Folder</button>
        </form>
        </div>
        </div>
        <hr>

        @if(session('success'))
            <div class="alert alert-success mt-4">
                <p>{{ session('success') }}</p>
                <p>View Link: <a href="{{ session('viewLink') }}" target="_blank">{{ session('viewLink') }}</a></p>
                <p>Download Link: <a href="{{ session('downloadLink') }}" target="_blank">{{ session('downloadLink') }}</a></p>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-4">
                <p>{{ session('error') }}</p>
            </div>
        @endif
    </div>
</body>
</html>