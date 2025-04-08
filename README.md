After Setup Run This Command

php artisan mary:install

In Livewire Vendor Folder A Bug Which Can Solve By Following Way.
vendor/livewire/livewire/src/Features/SupportFileUploads/FilePreviewController.php

Line no 20
Comment That Line For Production

// abort_unless(request()->hasValidSignature(), 401);
