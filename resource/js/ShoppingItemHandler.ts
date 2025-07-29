import {IShoppingItem, ShoppingItemRepository} from "./repositories/ShoppingItemRepository";
import {alertModal} from "./modal";

export default class ShoppingItemHandler {

    private items: IShoppingItem[] = [];

    constructor(
        private shoppingItemWrapper: HTMLDivElement
    ) {
        this.shoppingItemWrapper.addEventListener('click', (e) => {
            const target = e.target as HTMLElement;
            // Adjust as needed for nested elements, maybe use closest()
            const listItem = target.closest('.list-item');
            if (listItem) {
                this.checkItemFn(listItem as HTMLElement);
            }

            const removeButton = target.closest('.remove-button')
            if (removeButton) {
                this.removeItemFn(removeButton as HTMLElement);
            }
        });
    }

    async checkItemFn(el: HTMLElement) {

        const itemId = el.getAttribute('data-id');

        el.classList.toggle('checked');

        (new ShoppingItemRepository()).toggleCheck(Number(itemId));

    }

    private removeItemFn(el: HTMLElement) {
        const itemId = Number(el.getAttribute('data-id'));

        this.items = this.items.filter(i => i.id !== itemId);
        this.loadItems(this.items);

        (new ShoppingItemRepository()).delete(itemId);
    }

    async init() {

        await this.getList();


        const addItemForm = document.querySelector('#add-item-form') as HTMLFormElement;

        // if (addItemForm) {
        //     new FormHandler(addItemForm, {
        //         fieldValidators: {
        //             name: [required],
        //             note: []
        //         },
        //         handleResponse: async (response) => {
        //             const item = response.data;
        //             shoppingItemWrapper.innerHTML += shoppingItemTemplate(item);
        //             await alertModal({
        //                 title: response.message
        //             });
        //         }
        //     });
        // }
    }

    async getList() {
        const [success, error] = await (new ShoppingItemRepository()).getAll();

        if (error) {
            await alertModal({
                title: error.message,
                body: 'Please try again later.',
                // buttons: [{
                //     label: 'Close',
                //     className: 'btn btn-secondary',
                //     // action: 'hideModal()'
                // }]
            });
            // return;
        }

        if (success) {
            this.items = success.data;
        }

        this.loadItems(this.items);
    }

    private loadItems(items: IShoppingItem[] | []) {
        this.shoppingItemWrapper.innerHTML = '';
        if (items.length) {
            items.forEach(item => {
                this.shoppingItemWrapper.innerHTML += this.shoppingItemTemplate(item);
            });
            return;
        }
        this.shoppingItemWrapper.innerHTML = '<p>No items found.</p>';
    }

    shoppingItemTemplate(item: IShoppingItem) {
        let template = '';

        template = `<div class="card">
        <div class="shopping-list">
            <div class="list-item-wrapper">
                <div class="list-item ${item.is_checked ? "checked" : ""}" data-id="${item?.id}">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21 7L9 19l-5.5-5.5l1.41-1.41L9 16.17L19.59 5.59z"/>
                        </svg>
                    </div>
                    <div class="list-title">${item.name ?? ""}</div>
                    
                    <div class="list-note">${item.note ?? ""}</div>
                </div>

                <div class="list-actions">
                    <button class="edit-button" onclick="this.parentElement.parentElement.querySelector('.edit-form').classList.toggle('open')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                        </svg>
                    </button>
                    <button class="remove-button" data-id="${item.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6q-.425 0-.712-.288T4 5t.288-.712T5 4h4q0-.425.288-.712T10 3h4q.425 0 .713.288T15 4h4q.425 0 .713.288T20 5t-.288.713T19 6v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zm-7 11q.425 0 .713-.288T11 16V9q0-.425-.288-.712T10 8t-.712.288T9 9v7q0 .425.288.713T10 17m4 0q.425 0 .713-.288T15 16V9q0-.425-.288-.712T14 8t-.712.288T13 9v7q0 .425.288.713T14 17M7 6v13z" />
                        </svg>
                    </button>
                </div>

                <form style="" class="edit-form" method="POST" action="/api/shopping-items/${item.id ?? ""}">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="note" class="form-label">Email address</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Edit the list</button>
                </form>
            </div>
        </div>

    </div>`;


        return template;
    }


}
