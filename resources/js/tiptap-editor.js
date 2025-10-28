import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'

let editor = null;

// Initialize Tiptap Editor
function initializeTiptapEditor() {
    const editorElement = document.querySelector('#tiptap-content');
    
    if (!editorElement) {
        console.error('Tiptap content element not found');
        return;
    }

    // Get initial content from hidden input (for old() values)
    const hiddenInput = document.getElementById('description');
    const initialContent = hiddenInput ? hiddenInput.value : '';

    editor = new Editor({
        element: editorElement,
        extensions: [
            StarterKit,
            Placeholder.configure({
                placeholder: 'Write your job description here or generate one with AI...',
            }),
        ],
        content: initialContent,
        onUpdate: ({ editor }) => {
            // Update hidden input with HTML content
            if (hiddenInput) {
                hiddenInput.value = editor.getHTML();
            }
        },
    });

    // Setup toolbar button handlers
    setupToolbarHandlers(editor);

    // Expose editor globally for other functions to use
    window.tiptapEditor = editor;
    
    console.log('Tiptap editor initialized successfully');
}

// Setup toolbar button handlers
function setupToolbarHandlers(editor) {
    document.querySelectorAll('.tiptap-btn').forEach(button => {
        button.addEventListener('click', () => {
            const action = button.dataset.action;
            const level = button.dataset.level;

            switch(action) {
                case 'bold':
                    editor.chain().focus().toggleBold().run();
                    break;
                case 'italic':
                    editor.chain().focus().toggleItalic().run();
                    break;
                case 'strike':
                    editor.chain().focus().toggleStrike().run();
                    break;
                case 'heading':
                    editor.chain().focus().toggleHeading({ level: parseInt(level) }).run();
                    break;
                case 'bulletList':
                    editor.chain().focus().toggleBulletList().run();
                    break;
                case 'orderedList':
                    editor.chain().focus().toggleOrderedList().run();
                    break;
                case 'blockquote':
                    editor.chain().focus().toggleBlockquote().run();
                    break;
                case 'horizontalRule':
                    editor.chain().focus().setHorizontalRule().run();
                    break;
                case 'undo':
                    editor.chain().focus().undo().run();
                    break;
                case 'redo':
                    editor.chain().focus().redo().run();
                    break;
            }

            // Update active states
            updateToolbarStates();
        });
    });

    // Update toolbar button active states
    function updateToolbarStates() {
        document.querySelectorAll('.tiptap-btn').forEach(button => {
            const action = button.dataset.action;
            const level = button.dataset.level;
            let isActive = false;

            switch(action) {
                case 'bold':
                    isActive = editor.isActive('bold');
                    break;
                case 'italic':
                    isActive = editor.isActive('italic');
                    break;
                case 'strike':
                    isActive = editor.isActive('strike');
                    break;
                case 'heading':
                    isActive = editor.isActive('heading', { level: parseInt(level) });
                    break;
                case 'bulletList':
                    isActive = editor.isActive('bulletList');
                    break;
                case 'orderedList':
                    isActive = editor.isActive('orderedList');
                    break;
                case 'blockquote':
                    isActive = editor.isActive('blockquote');
                    break;
            }

            if (isActive) {
                button.classList.add('is-active');
            } else {
                button.classList.remove('is-active');
            }
        });
    }

    // Listen for editor updates to update toolbar states
    editor.on('selectionUpdate', updateToolbarStates);
    editor.on('transaction', updateToolbarStates);
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeTiptapEditor);
} else {
    initializeTiptapEditor();
}

export { editor, initializeTiptapEditor };
