import http, {IError, IResponse} from "../http";

export interface IShoppingItem {
    id?: number;
    user_id: number; // Assuming user_id is not part of the model but used in repository
    name: string;
    note: string;
    quantity: number;
    is_checked?: boolean;
    created_at?: string | null;
    updated_at?: string | null;
}

export class ShoppingItemRepository {

    async getAll() {
        return await http<IShoppingItem[]>(
            "/shopping-items"
        )
    }

    async delete(id: number) {
        return await http<IShoppingItem[]>(
            `/shopping-items/${id}`,
            "DELETE"
        )
    }

    async toggleCheck(id: number) {
        return await http<IShoppingItem[]>(
            `/shopping-items/${id}/toggle-check`,
            "PATCH"
        )
    }


}