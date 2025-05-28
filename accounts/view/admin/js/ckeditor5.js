import {
    ClassicEditor,
    Autosave,
    Bold,
    Essentials,
    Italic,
    SelectAll,
    Undo,
    SimpleUploadAdapter,
    List
} from 'ckeditor5';

const editorConfig = {
    toolbar: ['bold', 'italic', '|', 'undo', 'redo', '|', 'numberedList', 'bulletedList', 'essentials'],
    plugins: [Autosave, Bold, Essentials, Italic, SelectAll, Undo, SimpleUploadAdapter, List],
    simpleUpload: {
    },
    image: {
        upload: {
            types: ['png', 'jpeg', 'webp']
        }
    }
};
ClassicEditor
    .create(document.querySelector('#long_description'), editorConfig)
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
