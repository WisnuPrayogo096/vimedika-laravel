@props(['name', 'value' => null])

<div class="mt-4">
    <input id="{{ $name }}" type="hidden" name="{{ $name }}" value="{!! $value ?? old($name) !!}">
    <trix-editor input="{{ $name }}" class="trix-content"></trix-editor>
</div>

@push('style')
    <link rel="stylesheet" href="{{ asset('css/rich-editor.css') }}">
    <style>
        .trix-content {
            @apply rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
            min-height: 300px;
            background: white;
            padding: 1rem;
        }

        trix-editor img {
            max-width: 100%;
            height: auto;
        }

        .trix-button-group--file-tools {
            display: flex !important;
        }

        .trix-button--icon-attach {
            position: relative;
        }

        .trix-button--icon-attach input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            left: 0;
            top: 0;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('js/rich-editor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.querySelector('trix-editor');

            document.addEventListener('trix-file-accept', function(event) {
                try {
                    const acceptedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (event?.file?.type && !acceptedTypes.includes(event.file.type)) {
                        event.preventDefault();
                        alert('Only JPEG, PNG, JPG, and GIF images are allowed');
                    }
                } catch (error) {
                    console.warn('File validation warning:', error);
                }
            });

            document.addEventListener('trix-attachment-add', function(event) {
                try {
                    if (!event?.attachment?.file) return;

                    const trixAttachment = event.attachment.attachment;

                    if (trixAttachment.previewURL && !trixAttachment.previewURL.startsWith('blob:')) {
                        return;
                    }

                    uploadImage(event.attachment);
                } catch (error) {
                    console.warn('Attachment add warning:', error);
                }
            });

            function uploadImage(attachment) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    console.error('CSRF token missing');
                    return;
                }

                const formData = new FormData();
                formData.append('image', attachment.file);

                fetch('/upload-image', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data?.imageUrl) throw new Error('No image URL returned');

                        const fullUrl = data.imageUrl.startsWith('http') ? data.imageUrl :
                            `${window.location.origin}${data.imageUrl}`;

                        if (attachment?.setAttributes) {
                            attachment.setAttributes({
                                url: fullUrl,
                                href: fullUrl,
                                _imageUrl: fullUrl
                            });
                        }
                    })
                    .catch(error => {
                        if (attachment?.remove) {
                            attachment.remove();
                        }
                        alert('Error uploading image. Please try again.');
                    });
            }
            document.addEventListener('trix-attachment-remove', function(event) {
                try {
                    const trixAttachment = event.attachment;
                    if (!trixAttachment) return;

                    console.log('Attachment removed:', trixAttachment);

                    const imageUrl = trixAttachment?.getAttribute('_imageUrl');
                    console.log('Image URL to be deleted:', imageUrl);

                    if (imageUrl && !imageUrl.startsWith('blob:')) {
                        deleteImage(imageUrl);
                    }

                    const previewURL = trixAttachment?.previewURL;
                    if (typeof previewURL === 'string' && previewURL.startsWith('blob:')) {
                        URL.revokeObjectURL(previewURL);
                    }
                } catch (error) {
                    console.warn('Blob cleanup warning:', error);
                }
            });

            function deleteImage(imageUrl) {
                console.log(imageUrl)
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    console.error('CSRF token missing');
                    return;
                }

                const relativePath = imageUrl.replace('/storage', '');

                fetch('/delete-image', {
                        method: 'POST',
                        body: JSON.stringify({
                            imageUrl: relativePath
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Image successfully deleted from server.');
                        } else {
                            console.error('Failed to delete the image.');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting image:', error);
                    });
            }
        });
    </script>
@endpush
