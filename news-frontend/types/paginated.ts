export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    total: number;
    next_page_url?: string;
    prev_page_url?: string;
}
