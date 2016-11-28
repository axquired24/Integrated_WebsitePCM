var photo_counter = {{ App\Models\Gallery::where('gallery_category_id', $arCategory->id)->count() }};
Dropzone.options.realDropzone = {

    uploadMultiple: false,
    parallelUploads: 1,
    maxFilesize: 8,
    {{-- maxFiles: {{ $limitImg }}, --}}
    previewsContainer: '#dropzonePreview',
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove',
    dictFileTooBig: 'Max ukuran gambar 8MB',
    dictMaxFilesExceeded: "Maximal - Gambar.",

    // The setting up of the dropzone
    init:function() {

        // this.on("sending", function(file, xhr, formData) {
        //     var name  = Date.now();
        //     formData.append(name, file);
        // });

        this.on("removedfile", function(file) {

            $.ajax({
                type: 'POST',
                url: '{{ url("upload/delete") }}',
                data: {id: file.serverFileName, _token: $('#csrf-token').val()},
                dataType: 'html',
                success: function(data){
                    var rep = JSON.parse(data);
                    if(rep.code == 200)
                    {
                        photo_counter--;
                        $("#photoCounter").text( "Terupload : (" + photo_counter + ") Gambar");
                    }

                }
            });

        } );
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    success: function(file,done) {
        file.serverFileName = done.filename; // harusnya variable filename dari ImageRepository
        photo_counter++;
        $("#photoCounter").text( "Terupload : (" + photo_counter + ") Gambar");
    }
}



