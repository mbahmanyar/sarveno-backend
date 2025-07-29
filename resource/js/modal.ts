interface IModalOptions {
    title?: string;
    body?: string;
    buttons?: Array<{ label: string, className: string, action: () => void }>;
}

const modal = document.querySelector('#modal') as HTMLDivElement;

// close modal when clicked around the box
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        hideModal();
    }
});


export function modalContent(modalOptions: IModalOptions) {
    let content = '';
    if (modalOptions.title) {
        content += `<h2>${modalOptions.title}</h2>`
    }
    if (modalOptions.body) {
        content += `<div class="modal-body">${modalOptions.body}</div>`;
    }
    if (modalOptions.buttons && modalOptions.buttons.length > 0) {
        content += `<div class="modal-actions">`;
        modalOptions.buttons.forEach(button => {
            content += `<button class="${button.className}" onclick="${button.action}">${button.label}</button>`;
        });
        content += `</div>`;
    }

    return content;
}

export async function alertModal(options: IModalOptions) {
    const content = modalContent(options);
    const modal = document.querySelector('#modal') as HTMLDivElement;
    console.log('o',options)
    modal.querySelector('.modal-content')!.innerHTML = content;

    showModal();

    await debounce(3000);

    hideModal();

}

export function showModal() {
    const modal = document.querySelector('#modal') as HTMLDivElement;
    if (modal) {
        modal.classList.remove('hidden');
    }
}

export function hideModal() {
    const modal = document.querySelector('#modal') as HTMLDivElement;

    modal.querySelector('.modal-content')!.innerHTML = '';

    if (modal) {
        modal.classList.add('hidden');
    }
}

export function toggleModal() {
    const modal = document.querySelector('#modal') as HTMLDivElement;
    if (modal) {
        modal.classList.toggle('hidden');
    }
}

async function debounce(timeout: number = 1000) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve(true);
        }, timeout);
    });
}