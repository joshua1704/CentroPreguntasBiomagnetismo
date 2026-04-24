import * as bootstrap from 'bootstrap';
import moment from 'moment';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Cargar editor Quill
    let quill = null;
    const editor = document.getElementById('editor');
    if (editor) {
        quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                        [{ 'align': [] }],
                        ['link', 'image'],
                    ],
                    handlers: {
                        image: imageHandler
                    }
                },
            }
        });

        setupImageResize(quill);
    }

    // Carga button loading despues del submit
    const questionForm = document.getElementById('questionForm');
    if (questionForm) {
        questionForm.addEventListener('submit', function() {
            document.getElementById('btnQuestionFormSpinner').classList.remove('d-none');
            document.getElementById('btnQuestionFormSubmit').classList.add('d-none');
        });
    }

    // Guardar HTML antes de submit
    const editQuestionForm = document.querySelector('#EditQuestionForm');
    if (editQuestionForm) {
        let content = document.getElementById('content');
        quill.root.innerHTML = content.value;
        editQuestionForm.addEventListener('submit', function() {
            document.getElementById('btnEditQuestionFormSpinner').classList.remove('d-none');
            document.getElementById('btnEditQuestionFormSubmit').classList.add('d-none');
            document.getElementById('content').value = quill.root.innerHTML;
        });
    }

    // Search params questions
    let inputSelectDate = document.querySelector('#inputSelectDate');
    if (inputSelectDate) {
        let hastaDate = document.querySelector('#hastaDate');
        let desdeDate = document.querySelector('#desdeDate ');
        let dateRange = document.querySelector('#dateRange');
        let cancelDate = document.querySelector('#cancelDate');

        inputSelectDate.addEventListener('change', function() {
            if (inputSelectDate.value == 'custome_range') {
                const today = new Date();
                const formatted = today.toISOString().split('T')[0];

                dateRange.classList.remove('d-none');
                inputSelectDate.classList.add('d-none');
                hastaDate.value = formatted;
                desdeDate.value = formatted;
            }
        });

        desdeDate.addEventListener('change', function() {
            hastaDate.min = this.value;
        });

        cancelDate.addEventListener('click', function() {
            dateRange.classList.add('d-none');
            inputSelectDate.classList.remove('d-none');
            inputSelectDate.value = '';
        })

    }

    // Formulario search params questions
    let searchParamsForm = document.querySelector('#searchParamsForm');
    if (searchParamsForm) {
        searchParamsForm.addEventListener('submit', function() {
            document.getElementById('btnSearchParamsSpinner').classList.remove('d-none');
            document.getElementById('btnSearchParamsSubmit').classList.add('d-none');
        });
    }

    // 🔥 SUBIR IMAGEN
    function imageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = async () => {
            const file = input.files[0];

            let formData = new FormData();
            formData.append('image', file);

            const response = await fetch('/admin/upload_image', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const data = await response.json();

            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', data.url);

            setTimeout(() => {
                const imgs = document.querySelectorAll('.ql-editor img');

                const img = imgs[imgs.length - 1]; // última imagen insertada

                if (img) {
                    img.style.width = '300px';
                    img.style.height = 'auto';
                }
            }, 50);
        };
    }

    function setupImageResize(quill) {
        let resizer = null;
        let activeImg = null;
        let startX, startWidth;

        quill.root.addEventListener('click', (e) => {
            if (e.target.tagName === 'IMG') {
            selectImage(e.target);
            } else {
            removeResizer();
            }
        });

        function selectImage(img) {
            activeImg = img;
            removeResizer();

            const rect = img.getBoundingClientRect();
            const editorRect = quill.root.getBoundingClientRect();

            resizer = document.createElement('div');
            resizer.className = 'image-resizer';
            resizer.style.left = rect.left - editorRect.left + quill.root.scrollLeft + 'px';
            resizer.style.top = rect.top - editorRect.top + quill.root.scrollTop + 'px';
            resizer.style.width = rect.width + 'px';
            resizer.style.height = rect.height + 'px';

            const handle = document.createElement('div');
            handle.className = 'handle se';
            resizer.appendChild(handle);

            quill.root.parentElement.style.position = 'relative';
            quill.root.parentElement.appendChild(resizer);

            handle.addEventListener('mousedown', startResize);
        }

        function startResize(e) {
            e.preventDefault();
            startX = e.clientX;
            startWidth = activeImg.offsetWidth;

            document.addEventListener('mousemove', resize);
            document.addEventListener('mouseup', stopResize);
        }

        function resize(e) {
            const dx = e.clientX - startX;
            const newWidth = Math.max(10, startWidth + dx); // mínimo 10px

            activeImg.style.width = newWidth + 'px';

            resizer.style.width = newWidth + 'px';
            resizer.style.height = (activeImg.offsetHeight) + 'px';
        }

        function stopResize() {
            document.removeEventListener('mousemove', resize);
            document.removeEventListener('mouseup', stopResize);
        }

        function removeResizer() {
            if (resizer) {
                resizer.remove();
                resizer = null;
            }
        }
    }
});
